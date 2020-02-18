"use strict";

import Connection from "./Connection";

class ConnectionManager {

    constructor() {
        this.connections = {};
    }

    getConnection(serverName) {
        if (this.connections[serverName]) {
            return this.connections[serverName];
        }

        this.connections[serverName] = new Connection(serverName);
        return this.connections[serverName];
    }

    getNewConnection(callback) {
        this.getAvailableShard((serverName) => {
            callback(this.getConnection(serverName));
        });
    }

    getAvailableShard(callback) {
        var serverNameRequest = new XMLHttpRequest();
        serverNameRequest.addEventListener("load", function() {
            const response = JSON.parse(this.response);
            callback(response.delegatedShard);
        });
        serverNameRequest.open("GET", "/poker-entrypoint/create");
        serverNameRequest.send();
    }

}

export default ConnectionManager;