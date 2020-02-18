"use strict";
class NavigationPanel {

    constructor(panelManager) {
        this.panelManager = panelManager;
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.element = document.querySelector('#navigation-panel');
        this.button = this.element.querySelector('.toggle-button');

        this.element.navigationPanel = this;
        this.button.navigationPanel = this;
        this.button.addEventListener('click', this.togglePanel);
        this.panelManager.register(this);
    }

    togglePanel() {
        if (this.navigationPanel.element.classList.contains('visible')) {
            this.navigationPanel.panelManager.closeAll();
        } else {
            this.navigationPanel.panelManager.open(this.navigationPanel);
        }
    }

    open() {
        this.panelManager.open(this);
    }

    showError(message)
    {
        this.errorMessage.innerText = message;
        this.errorMessage.classList.add('visible');
    }

}

export default NavigationPanel;
