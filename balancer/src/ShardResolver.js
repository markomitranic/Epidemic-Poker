"use strict";

class ShardResolver {

    constructor() {
        this.nextShard = 0;
        this.shardsMap = [
            '1',
        ];
    }

    resolve(request, response) {
        response.send({
            'success': true,
            'delegatedShard': this.shardsMap[this.nextShard]
        });

        // A simple round robin here.
        this.nextShard++;
        if (this.nextShard >= this.shardsMap.length) {
            this.nextShard = 0;
        }
    }

}

module.exports = new ShardResolver();