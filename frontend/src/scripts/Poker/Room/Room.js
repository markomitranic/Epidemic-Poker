"use strict";

import Message from "../Message";
import Round from "./Round";
import Vote from "./Vote";

class Room {

    constructor(name, connection) {
        this.name = name;
        this.clientName = '👎';
        this.connection = connection;
        this.type = 'default';
        this.results = [];
        this.currentRound = 0;

        this.connection.onMessage((message) => {this.messageListener(message);});
    }

    getCurrentRound() {
        return this.results[this.currentRound];
    }

    messageListener(message) {
        if (message.title === 'voteChange' && message.payload.roomId === this.name) {
            this.addVote(new Vote(data.payload.name, data.payload.value));
        }
    }

    join() {
        this.connection.send(new Message('join', {roomId: this.name}));
    }

    addVote(vote) {
        this.getCurrentRound().addVote(vote);
        this.connection.send(new Message('vote', {roomId: this.name, value: vote.value}));
    }

    coffeeBreak() {
        this.connection.send(new Message('coffeeBreak', {roomId: this.name, clientName: this.clientName}));
    }

    leave() {

    }

    initialState(state) {
        this.currentRound = parseInt(state.currentRound);
        this.type = state.type;
        this.clientName = state.clientName;

        state.results.forEach((round) => {
            this.results.push(this.parseRoundInput(round));
        });
    }

    parseRoundInput(roundData) {
        const round = new Round();
        for (let i = 0; i < roundData.length; i++) {
            round.addVote(new Vote(roundData[i].name, roundData[i].value));
        }
        return round;
    }


}

export default Room;