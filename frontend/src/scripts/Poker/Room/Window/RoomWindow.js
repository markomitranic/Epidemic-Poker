"use strict";

import VoteControls from "./VoteControls";
import ShareControls from "./ShareControls";
import VisualControls from "./VisualControls";

class RoomWindow {

    constructor() {
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.main = document.querySelector('main');
        this.roomWindow = this.main.querySelector('#room-window');
        this.userName = this.main.querySelector('.user-name');
        this.roomTitle = this.roomWindow.querySelector('h1 span');
        this.roundNumber = this.roomWindow.querySelector('.round span');
        this.votingButtonsContainer = this.roomWindow.querySelector('.voting-buttons');
        this.voteControls = new VoteControls(this.votingButtonsContainer);
        this.userActions = this.roomWindow.querySelector('.user-actions');
        this.shareControls = new ShareControls(this.userActions.querySelector('.share'));
        this.userActions.coffeeButton = this.userActions.querySelector('.coffee-break');
        this.userActions.leaveButton = this.userActions.querySelector('.leave-room');
        this.visualControls = new VisualControls(this.roomWindow.querySelector('#visual'));
    }

    show(room) {
        this.populateData(room);
    }

    populateData(room) {
        this.userName.innerText = room.clientName;
        this.roomTitle.innerText = room.name.charAt(0).toUpperCase() + room.name.slice(1);
        this.roundNumber.innerText = room.currentRound + 1;
        this.voteControls.initialize(room);
        this.shareControls.populate(room);
        this.main.classList.add('room-open');
        this.userActions.coffeeButton.room = room;

        this.userActions.coffeeButton.removeEventListener('click', this.askForCoffee);
        this.userActions.coffeeButton.addEventListener('click', this.askForCoffee);
    }

    askForCoffee() {
        this.room.coffeeBreak();
    }

}

const singletonInstance = new RoomWindow();

export default singletonInstance;