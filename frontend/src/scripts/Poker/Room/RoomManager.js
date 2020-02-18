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
        connection.onClose(this.connectionClose);

        this.rooms[roomName] = new Room(roomName, connection);
        return this.rooms[roomName];
    }

    connectionClose(connection) {
        this.rooms.forEach(function (room) {
            if (room.connection === connection) {
                delete this.rooms[room.name];
            }
        });
    }

}

export default RoomManager;