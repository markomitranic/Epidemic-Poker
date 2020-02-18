"use strict";

import Cookie from "../Cookie";
import ErrorMessage from "../Panels/ErrorMessage";

class Connection {

    constructor(serverName) {
        this.serverName = serverName;
        this.openEvent = null;
        this.observers = {
            open: [],
            message: [],
            close: [],
            error: []
        };

        this.socket = new WebSocket(`ws://${location.host}/poker-entrypoint/${serverName}`);
        this.socket.connection = this;

        this.socket.onopen = function (event) {
            this.connection.openEvent = event;
            console.info('Connection to server open, waiting for auth.');
        };
        this.socket.onmessage = function (event) {
            this.connection.triggerObservers('open', JSON.parse(event.data));
            this.connection.triggerObservers('message', JSON.parse(event.data));
        };
        this.socket.onclose = function (event) {
            if (!event.wasClean) {
                new ErrorMessage('Uh oh! Server dropped the connection. Try re-joining a room or reloading the page.')
            }
            this.connection.triggerObservers('close', this.connection);
        };
        this.socket.onerror = function (event) {
            console.error('eror');
            this.connection.triggerObservers('error', event);
        };

        this.onMessage((data) => {
            this.sessionChange(data, this);
        });
        this.onError(function(e) {
           new ErrorMessage('Unable to connect to server.');
        });
    }

    send(message) {
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
        if (this.openEvent === null) {
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

    removeObserver(collectionName, observer) {
        this.observers[collectionName].forEach((existingObserver, key) => {
            if (Object.is(existingObserver, observer)) {
                delete this.observers[key];
            }
        });
    }

    triggerObservers(collectionName, event) {
        console.debug(collectionName, event);
        this.observers[collectionName].forEach((observer) => {
            observer.observer(event, observer.context);
        });

        if (collectionName === 'open') {
            // Open should always be emptied after use, because it is used as a queue.
            this.observers.open = [];
        }
    }

    sessionChange(data) {
        if (data.title === 'sessionChange') {
            Cookie.create(data.payload.cookieName, data.payload.token, 1);
            console.debug('Received a session change request.', data.payload);
            this.triggerObservers('open', this.openEvent);
        } else if (data.title === 'authSuccess') {
            this.triggerObservers('open', this.openEvent);
        }
    }

}

export default Connection;
