"use strict";

class ShareControls {

    constructor(container) {
        this.shareableLink = container.querySelector('.shareable-link span');
        this.shareableCodeBlocks = container.querySelectorAll('.shareable-code span');
    }

    populate(room) {
        this.shareableLink.innerText = `http://${location.host}/${room.connection.serverName}/${room.name}`;
        this.shareableCodeBlocks[0].innerText = room.connection.serverName;
        this.shareableCodeBlocks[1].innerText = room.name;
    }

}

export default ShareControls;