"use strict";

import Cookie from "../Cookie";

class Connection {

    constructor(serverName) {
        this.serverName = serverName;
        this.observers = {
            open: [],
            message: [],
            close: [],
            error: []
        };

        this.socket = new WebSocket(`ws://${location.host}/poker-entrypoint/${serverName}`);
        this.socket.connectionManager = this;

        this.socket.onopen = function (event) {
            this.connectionManager.triggerObservers('open', event);
        };
        this.socket.onmessage = function (event) {
            this.connectionManager.triggerObservers('message', JSON.parse(event.data));
        };
        this.socket.onclose = function (event) {
            this.connectionManager.triggerObservers('close', event);
        };
        this.socket.onerror = function (event) {
            this.connectionManager.triggerObservers('error', event);
        };

        this.onMessage(this.sessionChange);
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
        console.debug('open', event);
        this.observers[collectionName].forEach(function (observer) {
            observer.observer(event, observer.context);
        });
    }

    sessionChange(data) {
        if (data.title === 'sessionChange') {
            Cookie.create(data.payload.cookieName, data.payload.token, 1);
            console.debug('Received a session change request.', data.payload);
        }
    }

}

export default Connection;
