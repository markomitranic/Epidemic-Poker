"use strict";

class Vote {

    constructor(voterName, value) {
        this.voterName = voterName;
        this.value = parseFloat(value);
    }

}

export default Vote;