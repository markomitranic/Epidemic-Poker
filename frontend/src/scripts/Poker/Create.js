"use strict";

import CreatePopup from "../Panels/CreatePopup";

class Create {

    constructor(panelManager, roomManager) {
        this.panelManager = panelManager;
        this.roomManager = roomManager;
        this.createPopup = new CreatePopup(panelManager, roomManager);
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.createButton = document.querySelector('#navigation-panel ul li.create-button');
        this.createButton.addEventListener('click', this.onClick);
        this.createButton.create = this;
    }

    onClick(event) {
        this.create.createPopup.open();
    }

}

export default Create;