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
        this.roomTitle = this.roomWindow.querySelector('h1 span');
        this.votingButtonsContainer = this.roomWindow.querySelector('.voting-buttons');
        this.voteControls = new VoteControls(this.votingButtonsContainer);
        this.userActions = this.roomWindow.querySelector('.user-actions');
        this.userActions.shareableLink = this.userActions.querySelector('.shareable-link span');
        this.userActions.shareableCodeBlocks = this.userActions.querySelectorAll('.shareable-code span');
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
        this.userActions.shareableLink.innerText = 'http://localhost:8080/kyoto/abercrombie';
        this.userActions.shareableCodeBlocks[0].innerText = room.connection.serverName;
        this.userActions.shareableCodeBlocks[1].innerText = room.name;
        this.main.classList.add('room-open');
    }

}

const singletonInstance = new RoomWindow();

export default singletonInstance;