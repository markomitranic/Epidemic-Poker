"use strict";
class Test {

    echo() {
        let socket = new WebSocket("ws://" + location.host + "/poker-endpoint/");
        console.log(socket);
    }

}

export default Test;
