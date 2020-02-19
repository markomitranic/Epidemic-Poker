"use strict";

class Round {

    constructor() {
        this.votes = [];
    }

    addVote(vote) {
        for (let i = 0; i < this.votes.length; i++) {
            if (this.votes[i].voterName === vote.voterName) {
                this.votes[i] = vote;
                return;
            }
        }
        this.votes.push(vote);
    }

    getCurrentMedianResult() {
        let sum = 0;
        for (let i = 0; i < this.votes.length; i++) {
            sum += this.votes[i].value;
        }
        return (sum / this.votes.length).toFixed(4);
    }

}

export default Round;