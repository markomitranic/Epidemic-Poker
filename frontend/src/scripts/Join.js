"use strict";
import JoinPopup from "./Panels/JoinPopup";

class Join {

    constructor(panelManager, roomManager) {
        this.joinPopup = new JoinPopup(panelManager, roomManager);
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.joinButton = document.querySelector('nav ul li.join-button');
        if (!this.joinButton) {
            throw "Unable to bootstrap join button.";
        }
        this.joinButton.addEventListener('click', this.onClick);
        this.joinButton.join = this;
    }

    onClick(event) {
        this.join.joinPopup.open();
    }

}

export default Join;
