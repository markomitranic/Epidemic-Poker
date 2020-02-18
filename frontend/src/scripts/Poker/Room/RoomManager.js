"use strict";

import Room from "./Room";
import ConnectionManager from "../ConnectionManager";

class RoomManager {

    constructor() {
        this.rooms = {};
        this.connectionManager = new ConnectionManager();
    }

    join(serverName, roomName) {
        const connection = this.connectionManager.getConnection(serverName);
        connection.onClose(this.connectionClose, this);

        this.rooms[roomName] = new Room(roomName, connection);
        return this.rooms[roomName];
    }

    connectionClose(connection, context) {
        Object.keys(context.rooms).forEach(function (key) {
            if (context.rooms[key].connection === connection) {
                delete context.rooms[key];
            }
        });
    }

}

export default RoomManager;