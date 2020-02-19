"use strict";

class SuccessMessage {

    constructor(message) {
        this.bootstrapDom();
        this.show(message);
    }

    bootstrapDom() {
        this.element = document.querySelector('#success-message');
        this.message = this.element.querySelector('.message');
        this.button = this.element.querySelector('.close-button');
        this.element.errorMessage = this;
        this.button.errorMessage = this;
        this.button.addEventListener('click', this.hide);
    }

    show(message) {
        this.message.innerText = message;
        this.element.classList.add('visible');
    }

    hide() {
        this.errorMessage.message.innerText = "";
        this.errorMessage.element.classList.remove('visible');
    }

}

export default SuccessMessage;