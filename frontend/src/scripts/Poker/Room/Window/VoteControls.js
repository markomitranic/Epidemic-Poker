'use strict';

import Vote from "../Vote";
import float from "../Type/Float";

class VoteControls {

    constructor(container) {
        this.container = container;
        this.type = float;
        this.room = null;
        this.currentResult = document.querySelector('#room-window p.result');
    }

    initialize(room) {
        this.container.textContent = '';
        this.room = room;
        this.type = room.type;
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
        buttonElement.addEventListener('click', (e) => {
            this.room.addMyVote(new Vote(this.room.clientName, buttonElement.dataset.value));
            e.target.parentNode.querySelectorAll('.selected').forEach((element) => {
                element.classList.remove('selected');
            });
            e.target.classList.add('selected');

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