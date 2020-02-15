"use strict";
class Test {

    echo() {
        let socket = new WebSocket("ws://" + location.host + "/poker-entrypoint/");

        socket.onopen = function(e) {
            socket.send('Good morning Mr. Server!');
        };

        socket.onmessage = function(event) {
            console.log('[incoming message]', event.data);
        };

        socket.onclose = function(event) {
            if (event.wasClean) {
                console.log(`[close] Connection closed cleanly, code=${event.code} reason=${event.reason}`);
            } else {
                console.log('[socket close] Server left.');
            }
        };

        socket.onerror = function(error) {
            console.error(`[socket error] ${error.message}`);
        };

    }

}

export default Test;
