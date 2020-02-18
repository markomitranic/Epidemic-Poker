"use strict";

import Room from "./Room";
import ConnectionManager from "../ConnectionManager";
import Message from "../Message";

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

    create(params) {
        this.connectionManager.getAvailableShard((serverName) => {
            const connection = this.connectionManager.getConnection(serverName);
            connection.onOpen(() => {
                connection.send(new Message('create', {configuration: params}));
            });
        });
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