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
            this.connection.triggerObservers('message', JSON.parse(event.data));
        };
        this.socket.onclose = function (event) {
            this.connection.triggerObservers('close', this.connection);
        };
        this.socket.onerror = function (event) {
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

    onMessage(observer, context) {
        this.addObserver('message', observer, context);
    }
    onOpen(observer, context) {
        this.addObserver('open', observer, context);
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

    triggerObservers(collectionName, event) {
        console.debug(collectionName, event);
        this.observers[collectionName].forEach(function (observer) {
            observer.observer(event, observer.context);
        });
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
