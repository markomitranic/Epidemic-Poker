"use strict";

import Type from "./Type";
import BaseType from "./BaseType";

class Emoji extends BaseType {

    constructor() {
        super();
        this.values = [];
    }

    getButtonValues() {
        if (!this.values.length) {
            this.values = this.calculateValues();
        }

        return this.values;
    }

    calculateValues() {
        return [
            new Type('fa-tired', 0),
            new Type('fa-surprise', 0.2),
            new Type('fa-meh-rolling-eyes', (0.2 * 2).toFixed(2)),
            new Type('fa-smile', (0.2 * 3).toFixed(2)),
            new Type('fa-grin', (0.2 * 4).toFixed(2)),
            new Type('fa-smile-wink', 1),
        ];
    }

}

const singletonInstance = new Emoji();

export default singletonInstance;