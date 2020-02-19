"use strict";

import Type from "./Type";
import BaseType from "./BaseType";

class Fibonacci extends BaseType {

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
        const results = [];
        const numbers = this.fibonacci(12);

        for (let i = 0; i < numbers.length; i++) {
            results.push(new Type(numbers[i].toString(), numbers[i]));
        }

        return results;
    }

    fibonacci (n) {
        if (n===1) {
            return [0, 1];
        } else {
            var s = this.fibonacci(n - 1);
            s.push(s[s.length - 1] + s[s.length - 2]);
            return s;
        }
    };

}

const singletonInstance = new Fibonacci();

export default singletonInstance;