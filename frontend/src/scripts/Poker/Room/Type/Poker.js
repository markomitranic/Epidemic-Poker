"use strict";

import Type from "./Type";
import BaseType from "./BaseType";

class Poker extends BaseType {

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
            new Type('0', 0),
            new Type('½', 0.005),
            new Type('1', 0.01),
            new Type('2', 0.02),
            new Type('3', 0.03),
            new Type('5', 0.05),
            new Type('8', 0.08),
            new Type('13', 0.13),
            new Type('20', 0.20),
            new Type('40', 0.40),
            new Type('100', 1.0),
            new Type('∞', 1.1)
        ];
    }

}

const singletonInstance = new Poker();

export default singletonInstance;