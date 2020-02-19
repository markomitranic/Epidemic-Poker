"use strict";

import VoteControls from "./VoteControls";
import ShareControls from "./ShareControls";

class RoomWindow {

    constructor() {
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.main = document.querySelector('main');
        this.roomWindow = this.main.querySelector('#room-window');
        this.roomTitle = this.roomWindow.querySelector('h1 span');
        this.votingButtonsContainer = this.roomWindow.querySelector('.voting-buttons');
        this.voteControls = new VoteControls(this.votingButtonsContainer);
        this.userActions = this.roomWindow.querySelector('.user-actions');
        this.shareControls = new ShareControls(this.userActions.querySelector('.share'));
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
        this.shareControls.populate(room);
        this.main.classList.add('room-open');
    }

}

const singletonInstance = new RoomWindow();

export default singletonInstance;