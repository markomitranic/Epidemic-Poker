"use strict";

import Room from "./Room";
import ConnectionManager from "../ConnectionManager";
import Message from "../Message";

class RoomManager {

    constructor() {
        this.rooms = {};
        this.connectionManager = new ConnectionManager();
        this.joinListener = null;
    }

    join(serverName, roomName) {
        const connection = this.connectionManager.getConnection(serverName);
        connection.onClose(this.connectionClose, this);

        let room = this.findRoomObjectByName(roomName, connection);
        if (!room) {
            room = this.createRoomObject(roomName, connection);
        }

        room.join();
        this.expectJoinInitialState(connection, room);
        return room;
    }

    create(params) {
        this.connectionManager.getAvailableShard((serverName) => {
            const connection = this.connectionManager.getConnection(serverName);
            connection.onOpen(() => {
                connection.send(new Message('create', params));
                this.expectCreateInitialState(connection);
            });
        });
    }

    findRoomObjectByName(roomName) {
        if (this.rooms.hasOwnProperty(roomName)) {
            return this.rooms[roomName];
        }
    }

    createRoomObject(roomName, connection) {
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

    expectJoinInitialState(connection, room) {
        this.removeJoinListener(connection);
        this.joinListener = (data) => {
            if (data.title === 'initialState') {
                this.removeJoinListener(connection);
                room.initialState(data.payload);
                console.log('stigla join soba', data);
            }
        };
        connection.addObserver('message', this.joinListener);
    }

    expectCreateInitialState(connection) {
        this.removeJoinListener(connection);
        this.joinListener = function(data, context) {
            context.removeJoinListener(connection);
            if (data.title === 'initialState') {
                const room = context.createRoomObject(data.payload.roomId, connection);
                room.initialState(data.payload);
            }
        };
        connection.addObserver('message', this.joinListener, this);
    }

    removeJoinListener(connection) {
        const oldObserver = connection.findExistingObserver('message', this.joinListener);
        if (oldObserver) {
            connection.removeObserver('message', oldObserver);
        }
    }
}

export default RoomManager;