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
        this.button = this.element.querySelector('button');
        this.roomAddressInput = this.element.querySelector('input');

        this.element.joinPopup = this;
        this.button.joinPopup = this;
        this.button.addEventListener('click', this.submitJoinRequest);
        this.popupManager.register(this);
    }

    submitJoinRequest() {
        const values = this.joinPopup.roomAddressInput.value.split('_');
        if (values.length !== 2) {
            new ErrorMessage('The room address should be separated by an underscore (_)');
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
