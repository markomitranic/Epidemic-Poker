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

    show(room, navigationLink) {
        this.populateData(room, navigationLink);
    }

    populateData(room, navigationLink) {
        this.room = room;
        this.navigationLink = navigationLink;
        this.userName.innerText = room.clientName;
        this.roomTitle.innerText = room.name.charAt(0).toUpperCase() + room.name.slice(1);
        this.roundNumber.innerText = room.currentRound + 1;
        this.voteControls.initialize(room);
        this.shareControls.populate(room);
        this.main.classList.add('room-open');

        this.userActions.coffeeButton.context = this;
        this.userActions.coffeeButton.removeEventListener('click', this.askForCoffee);
        this.userActions.coffeeButton.addEventListener('click', this.askForCoffee);
        this.userActions.leaveButton.context = this;
        this.userActions.leaveButton.removeEventListener('click', this.leaveRoom);
        this.userActions.leaveButton.addEventListener('click', this.leaveRoom);
    }

    askForCoffee() {
        this.context.room.coffeeBreak();
    }

    leaveRoom() {
        this.context.room.leave();
        this.context.main.classList.remove('room-open');
        this.context.navigationLink.remove();
    }

}

const singletonInstance = new RoomWindow();

export default singletonInstance;