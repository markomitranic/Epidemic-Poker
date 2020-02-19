"use strict";

import Type from "./Type";
import BaseType from "./BaseType";

class Float extends BaseType {

    constructor() {
        super();
        this.values = [];
    }

    getButtonValues() {
        if (!this.values.length) {
            this.values = [
                new Type('0.1', 0.1),
                new Type('0.2', 0.2),
                new Type('0.3', 0.3),
                new Type('0.4', 0.4),
                new Type('0.5', 0.5),
                new Type('0.6', 0.6),
                new Type('0.7', 0.7),
                new Type('0.8', 0.8),
                new Type('0.9', 0.9),
                new Type('1.0', 1.0)
            ];
        }

        return this.values;
    }

}

const singletonInstance = new Float();

export default singletonInstance;