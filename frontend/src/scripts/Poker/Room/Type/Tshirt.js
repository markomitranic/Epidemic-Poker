"use strict";

import Type from "./Type";
import BaseType from "./BaseType";

class Tshirt extends BaseType {

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
            new Type('Xs', 0),
            new Type('S', 0.25),
            new Type('M', (0.25 * 2).toFixed(2)),
            new Type('L', (0.25 * 3).toFixed(2)),
            new Type('XL', 1),
        ];
    }

}

const singletonInstance = new Tshirt();

export default singletonInstance;