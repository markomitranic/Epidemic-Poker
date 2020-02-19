"use strict";

class BaseType {

    getLabelForValue(value) {
        const buttonValues = this.getButtonValues();
        let bestMatch = buttonValues[0];
        let bestMatchDiff = 1;

        for (let i = 0; i < buttonValues.length; i++) {
            let difference = Math.abs((buttonValues[i].value - value));
            if (difference < bestMatchDiff ) {
                bestMatch = buttonValues[i];
                bestMatchDiff = difference;
            }
        }

        return bestMatch.title;
    }

}

export default BaseType;