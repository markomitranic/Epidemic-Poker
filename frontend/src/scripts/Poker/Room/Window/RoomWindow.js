"use strict";

import VoteControls from "./VoteControls";

class RoomWindow {

    constructor() {
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.main = document.querySelector('main');
        this.noRoomWarning = this.main.querySelector('#no-rooms');
        this.roomWindow = this.main.querySelector('#room-window');
        this.roomTitle = this.roomWindow.querySelector('h1');
        this.votingButtonsContainer = this.roomWindow.querySelector('.voting-buttons');
        this.voteControls = new VoteControls(this.votingButtonsContainer);
        this.userActions = this.roomWindow.querySelector('.user-actions');
        this.userActions.coffeeButton = this.userActions.querySelector('.coffee-break');
        this.userActions.leaveButton = this.userActions.querySelector('.leave-room');
        this.visualContainer = this.roomWindow.querySelector('#visual');
    }

    show(room) {
        this.populateData(room);
    }

    populateData(room) {
        this.roomTitle.innerText = room.name.charAt(0).toUpperCase() + room.name.slice(1);
        this.voteControls.initialize(room);
    }

}

const singletonInstance = new RoomWindow();

export default singletonInstance;