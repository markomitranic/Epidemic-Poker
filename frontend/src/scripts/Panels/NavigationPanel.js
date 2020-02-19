"use strict";
class NavigationPanel {

    constructor(panelManager) {
        this.panelManager = panelManager;
        this.roomList = [];
        this.bootstrapDom();
    }

    bootstrapDom() {
        this.element = document.querySelector('#navigation-panel');
        this.button = this.element.querySelector('.toggle-button');
        this.roomListContainer = this.element.querySelector('ul.rooms-list');

        this.element.navigationPanel = this;
        this.button.navigationPanel = this;
        this.button.addEventListener('click', this.togglePanel);
        this.panelManager.register(this);
    }

    addRoom(room) {
        if (this.roomList) {
            for(let i=0; i < this.roomList.length; i++) {
                if (this.roomList[i].roomObject === room) {
                    return;
                }
            }
        }

        const newItem = document.createElement('li');
        newItem.innerText = room.name.charAt(0).toUpperCase() + room.name.slice(1);
        newItem.roomObject = room;
        this.roomList.push(newItem);
        //listener
        this.roomListContainer.appendChild(newItem);
    }

    removeRoom(room) {

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

}

export default NavigationPanel;
