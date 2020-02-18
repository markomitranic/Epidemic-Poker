"use strict";

class ShardResolver {

    constructor() {
        this.nextShard = 0;
        this.shardsMap = [
            '1',
        ];
    }

    resolve(request, response) {
        const responseShard = this.shardsMap[this.nextShard];

        // A simple round robin here.
        this.nextShard++;
        if (this.nextShard >= this.shardsMap.length) {
            this.nextShard = 0;
        }

        return responseShard;
    }

}

module.exports = new ShardResolver();