"use strict";

import Message from "../Message";
import Round from "./Round";
import Vote from "./Vote";

class Room {

    constructor(name, connection, roomTypeResolver) {
        this.name = name;
        this.clientName = '👎';
        this.connection = connection;
        this.type = null;
        this.results = [];
        this.currentRound = 0;
        this.visualControls = null;
        this.roomTypeResolver = roomTypeResolver;

        this.connection.onMessage((message) => {this.messageListener(message);});
    }

    getCurrentRound() {
        return this.results[this.currentRound];
    }

    messageListener(message) {
        if (message.title === 'voteChange' && message.payload.roomId === this.name) {
            this.addVote(new Vote(message.payload.name, message.payload.value));
        }
    }

    join() {
        this.connection.send(new Message('join', {roomId: this.name}));
    }

    addMyVote(vote) {
        this.addVote(vote);
        this.connection.send(new Message('vote', {roomId: this.name, value: vote.value}));
    }

    addVote(vote) {
        this.getCurrentRound().addVote(vote);
        this.visualControls.populate(this);
    }

    coffeeBreak() {
        this.connection.send(new Message('coffeeBreak', {roomId: this.name, clientName: this.clientName}));
    }

    leave() {
        this.connection.send(new Message('leave', {roomId: this.name}));
    }

    initialState(state) {
        this.currentRound = parseInt(state.currentRound);
        this.type = this.roomTypeResolver.resolve(state.type);
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