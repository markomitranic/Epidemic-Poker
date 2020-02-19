"use strict";

import Cookie from './Cookie';

class RedirectService {

    constructor(roomManager) {
        this.roomManager = roomManager;
    }

    redirectWithAutojoin() {
        const segments = window.location.pathname.split("/");
        const address = {
            serverName: segments[2],
            roomName: segments[3]
        };

        Cookie.create('automaticallyJoinRoom', JSON.stringify(address), 1);
        window.location.href = '/';
    }

    checkForAutojoin() {
        const addressValue = Cookie.read('automaticallyJoinRoom');
        if (addressValue) {
            const address  = JSON.parse(addressValue);
            Cookie.erase('automaticallyJoinRoom');
            this.roomManager.join(address.serverName, address.roomName);
        }
    }

}

export default RedirectService;