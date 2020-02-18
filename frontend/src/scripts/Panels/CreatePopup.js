"use strict";

import ErrorMessage from "./ErrorMessage";

class CreatePopup {

    constructor(panelManager, roomManager) {
        this.panelManager = panelManager;
        this.roomManager = roomManager;
        this.selectedType = null;
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.element = document.querySelector('#create-popup');
        this.button = this.element.querySelector('button');
        this.options = this.element.querySelectorAll('ul li');

        this.element.createPopup = this;
        this.button.createPopup = this;
        this.button.addEventListener('click', this.submitCreateRequest);
        this.options.forEach((option) => {
            option.createPopup = this;
            option.addEventListener('click', this.pickOption);
        });
        this.panelManager.register(this);
    }

    submitCreateRequest() {
        if (!this.createPopup.selectedType) {
            new ErrorMessage('Poker type must be selected during room creation.');
            return;
        }

        this.createPopup.roomManager.create({
            type: this.createPopup.selectedType
        });
        this.createPopup.close();
    }

    pickOption() {
        this.createPopup.options.forEach((option) => {
            option.classList.remove('selected');
        });
        this.classList.add('selected');
        this.createPopup.selectedType = this.dataset.type;
    }

    open() {
        this.panelManager.open(this);
    }

    close() {
        this.panelManager.closeAll();
    }


}

export default CreatePopup;