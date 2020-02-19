"use strict";

import Message from "../Message";

class Room {

    constructor(name, connection) {
        this.name = name;
        this.connection = connection;

        this.connection.onMessage((message) => {
            if (message.title === 'vote' && message.payload.roomId === this.name) {
                this.messageListener(message.payload);
            }
        });
    }

    messageListener(data) {
        console.log('got message into room', this.name, data);
    }

    join() {
        this.connection.send(new Message('join', {roomId: this.name}));
    }

    initialState(state) {
        /// ovo zapravo ne radi nista. treba da dodam listener za kreaciju sledece
        console.log('stigo state u ovu sobu', state);
    }


}

export default Room;