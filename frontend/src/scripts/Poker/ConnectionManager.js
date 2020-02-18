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

}

export default ConnectionManager;