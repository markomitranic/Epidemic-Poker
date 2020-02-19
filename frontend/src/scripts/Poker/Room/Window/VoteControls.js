'use strict';

import float from "../Type/Float";
import fibonacci from "../Type/Fibbonacci";
import poker from "../Type/Poker";
import natural from "../Type/Natural";
import tshirt from "../Type/Tshirt";
import emoji from "../Type/Emoji";
import Vote from "../Vote";

class VoteControls {

    constructor(container) {
        this.types = {
            poker: poker,
            fibonacci: fibonacci,
            natural: natural,
            tshirt: tshirt,
            emoji: emoji,
            float: float,
        };

        this.container = container;
        this.type = this.types.float;
        this.room = null;
        this.currentResult = document.querySelector('#room-window p.result');
    }

    initialize(room) {
        this.container.textContent = '';
        if (this.types.hasOwnProperty(room.type)) {
            this.type = this.types[room.type];
        }
        this.room = room;
        this.updateMedianScore();
        this.createButtons();
    }

    createButtons() {
        const values = this.type.getButtonValues();
        values.forEach((button) => {
            this.createButton(button);
        });
    }

    createButton(button) {
        const buttonElement = document.createElement('li');
        buttonElement.innerText = button.title;
        buttonElement.dataset.value = button.value;
        buttonElement.addEventListener('click', () => {
            this.room.addVote(new Vote(this.room.clientName, buttonElement.dataset.value));
            this.updateMedianScore();
        });
        this.container.append(buttonElement);
    }

    updateMedianScore() {
        this.currentResult.innerText = this.getCurrentResultLabel();
    }

    getCurrentResultLabel() {
        return this.type.getLabelForValue(
            this.room.getCurrentRound().getCurrentMedianResult()
        );
    }

}

export default VoteControls