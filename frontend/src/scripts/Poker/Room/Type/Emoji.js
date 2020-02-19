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
            new Type('🤗', 0),
            new Type('😃', 0.2),
            new Type('🙂', (0.2 * 2).toFixed(2)),
            new Type('😕', (0.2 * 3).toFixed(2)),
            new Type('😞', (0.2 * 4).toFixed(2)),
            new Type('😩', 1),
        ];
    }

}

const singletonInstance = new Emoji();

export default singletonInstance;