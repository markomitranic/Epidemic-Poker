"use strict";

import Type from "./Type";
import BaseType from "./BaseType";

class Natural extends BaseType {

    constructor() {
        super();
        this.values = [];
    }

    getButtonValues() {
        if (!this.values.length) {
            for (let i = 0; i <= 100; i++) {
                this.values.push(new Type(i.toString(), (i/100)));
            }
        }

        return this.values;
    }

}

const singletonInstance = new Natural();

export default singletonInstance;