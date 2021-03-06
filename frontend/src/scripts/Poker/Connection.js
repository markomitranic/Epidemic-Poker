"use strict";

import Cookie from "../Cookie";
import ErrorMessage from "../Panels/ErrorMessage";
import SuccessMessage from "../Panels/SuccessMessage";

class Connection {

    constructor(serverName) {
        this.serverName = serverName;
        this.openEvent = null;
        this.authorized = false;
        this.observers = {
            open: [],
            message: [],
            close: [],
            error: [],
            initialState: null
        };

        this.socket = new WebSocket(`ws://${location.host}/poker-entrypoint/${serverName}`);
        this.socket.connection = this;

        this.socket.onopen = function (event) {
            this.connection.openEvent = event;
            console.info('Connection to server open, waiting for auth.');
        };
        this.socket.onmessage = function (event) {
            if (this.connection.observers.open.length) {
                if (this.connection.openEvent !== null && this.connection.authorized) {
                    this.connection.triggerObservers('open', JSON.parse(event.data));
                }
            }
            this.connection.triggerObservers('message', JSON.parse(event.data));
        };
        this.socket.onclose = function (event) {
            if (!event.wasClean) {
                new ErrorMessage('Uh oh! Server dropped the connection. Try re-joining a room or reloading the page.')
            }
            this.connection.triggerObservers('close', this.connection);
        };
        this.socket.onerror = function (event) {
            this.connection.triggerObservers('error', event);
        };

        this.bootstrapObservers();
    }

    send(message) {
        if (this.openEvent === null || !this.authorized) {
            this.addObserver('open', () => {
                console.debug('Sending message', message);
                this.socket.send(JSON.stringify(message));
            });
            return;
        }

        console.debug('Sending message', message);
        this.socket.send(JSON.stringify(message));
    }
    close(code = 1000, message = 'Bye bye.') {
        this.socket.close(code, message);
    }

    onMessage(observer, context) {
        this.addObserver('message', observer, context);
    }
    onOpen(observer, context) {
        if (this.openEvent === null || !this.authorized) {
            this.addObserver('open', observer, context);
            return;
        }
        observer(this.openEvent, context);
    }
    onClose(observer, context) {
        this.addObserver('close', observer, context);
    }
    onError(observer, context) {
        this.addObserver('error', observer, context);
    }

    addObserver(collectionName, observer, context) {
        if (collectionName === 'initialState') {
            this.addInitialStateObserver(collectionName, observer, context);
            return;
        }

        this.observers[collectionName].forEach(function (existingObserver) {
            if (existingObserver.observer === observer) {
                return existingObserver;
            }
        });

        return this.observers[collectionName].push({
            context: context,
            observer: observer
        });
    }

    addInitialStateObserver(collectionName, observer, context) {
        return this.observers.initialState = {
            context: context,
            observer: observer
        };
    }

    removeObserver(collectionName, observer) {
        this.observers[collectionName].forEach((existingObserver, key) => {
            if (Object.is(existingObserver, observer)) {
                delete this.observers[key];
            }
        });
    }

    findExistingObserver(collectionName, callback) {
        for (let i = 0; i < this.observers[collectionName].length; i++) {
            if (Object.is(this.observers[collectionName][i].observer, callback)) {
                return this.observers[collectionName][i];
            }
        }
    }

    triggerObservers(collectionName, event) {
        console.debug(collectionName, event);
        this.observers[collectionName].forEach((observer) => {
            observer.observer(event, observer.context);
        });

        if (collectionName === 'open') {
            // Open should always be emptied after use, because it is used as a fifo queue.
            this.observers.open = [];
        }
    }

    bootstrapObservers() {
        this.onError(function(e) {
            console.error('Unable to connect to server.', e);
            new ErrorMessage('Unable to connect to server.');
        });
        this.onMessage((data) => {
            if (data.title === 'error') {
                console.error('Server sent out an error.', data);
                new ErrorMessage(data.payload.errorMessage);
            }
        });
        this.onMessage((data) => {
            if (data.title === 'sessionChange') {
                this.authorized = true;
                Cookie.create(data.payload.cookieName, data.payload.token, 1);
                console.debug('Received a session change request.', data.payload);
                this.triggerObservers('open', this.openEvent);
            }
        });
        this.onMessage((data) => {
            if (data.title === 'authSuccess') {
                this.authorized = true;
                this.triggerObservers('open', this.openEvent);
            }
        });
        this.onMessage((data) => {
            if (data.title === 'coffeeBreak') {
                new SuccessMessage(`${data.clientName} asked everyone for a ☕️ break.`);
            }
        });
        this.onMessage((data) => {
            if (data.title === 'initialState') {
                if (this.observers.initialState) {
                    this.observers.initialState.observer(data, this.observers.initialState.context);
                    this.observers.initialState = null;
                }
            }
        });
    }

}

export default Connection;
