"use strict";

import poker from "./Poker";
import fibonacci from "./Fibbonacci";
import natural from "./Natural";
import tshirt from "./Tshirt";
import emoji from "./Emoji";
import float from "./Float";

class RoomTypeResolver {

    constructor() {
        this.types = {
            poker: poker,
            fibonacci: fibonacci,
            natural: natural,
            tshirt: tshirt,
            emoji: emoji,
            float: float,
        };
    }

    resolve(typeName) {
        if (this.types.hasOwnProperty(typeName)) {
            return this.types[typeName];
        }
        return this.types.float;
    }

}

export default RoomTypeResolver;