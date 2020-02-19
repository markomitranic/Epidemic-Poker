"use strict";

import Room from "./Room";
import ConnectionManager from "../ConnectionManager";
import Message from "../Message";

class RoomManager {

    constructor(navigationPanel, roomWindow) {
        this.rooms = {};
        this.navigationPanel = navigationPanel;
        this.roomWindow = roomWindow;
        this.connectionManager = new ConnectionManager();
    }

    join(serverName, roomName) {
        const connection = this.connectionManager.getConnection(serverName);
        connection.onClose(this.connectionClose, this);

        let room = this.findRoomObjectByName(roomName, connection);
        if (!room) {
            room = this.createRoomObject(roomName, connection);
        }

        room.join();
        this.expectInitialState(connection, room);
        return room;
    }

    create(params) {
        this.connectionManager.getAvailableShard((serverName) => {
            const connection = this.connectionManager.getConnection(serverName);
            connection.onOpen(() => {
                connection.send(new Message('create', params));
                this.expectInitialState(connection);
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

    expectInitialState(connection, room) {
        connection.addObserver(
            'initialState',
            (data) => {
                if (!room) {
                    room = this.findRoomObjectByName(data.payload.roomId);
                    if (!room) {
                        room = this.createRoomObject(data.payload.roomId, connection);
                    }
                }
                room.initialState(data.payload);
                this.navigationPanel.addRoom(room);
                this.roomWindow.show(room);
            },
            this
        );
    }

}

export default RoomManager;