"use strict";
import ErrorMessage from "./ErrorMessage";

class JoinPopup {

    constructor(popupManager, roomManager) {
        this.popupManager = popupManager;
        this.roomManager = roomManager;
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.element = document.querySelector('#join-popup');
        this.form = this.element.querySelector('form');
        this.button = this.form.querySelector('button');
        this.gsInput = this.form.querySelector('#join-gs-name');
        this.roomInput = this.form.querySelector('#join-room-name');

        this.element.joinPopup = this;
        this.button.joinPopup = this;
        this.button.addEventListener('click', this.submitJoinRequest);
        this.form.addEventListener('submit', this.submitJoinRequest);
        this.popupManager.register(this);
    }

    submitJoinRequest(e) {
        e.preventDefault();
        const values = [this.joinPopup.gsInput.value, this.joinPopup.roomInput.value];
        if (values.length !== 2 || !values[0].length || !values[1].length) {
            new ErrorMessage('Both fields must be filled if you want us to find the room.');
            return;
        }
        this.joinPopup.roomManager.join(values[0], values[1]);
        this.joinPopup.close();
    }

    open() {
        this.popupManager.open(this);
    }

    close() {
        this.popupManager.closeAll();
    }

}

export default JoinPopup;
