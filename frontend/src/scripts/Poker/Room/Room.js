"use strict";

import Message from "../Message";

class Room {

    constructor(name, connection) {
        this.name = name;
        this.connection = connection;

        this.connection.onOpen(this.join, this);
        this.connection.onMessage(this.messageListener, this);
    }

    messageListener(data, context) {
        console.log('got message here', data);
    }

    join(data, context) {
        context.connection.send(new Message('join', {roomId: this.name}));
    }


}

export default Room;