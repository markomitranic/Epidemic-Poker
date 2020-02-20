"use strict";

class Pie {

    constructor(container) {
        this.container = container;
        this.bootstrapDom();
        this.initChart();
    }

    bootstrapDom() {
        this.chartElement = document.createElement('div');
        this.chartElement.id = 'pie-chart';
        this.chartElement.style.height = '370px';
        this.chartElement.style.width = '100%';
        this.container.append(this.chartElement);
    }

    initChart() {
        this.chart = new CanvasJS.Chart(this.chartElement, {
            animationEnabled: true,
            data: [{
                type: "pie",
                startAngle: 240,
                indexLabel: "{label}",
                dataPoints: [
                ]
            }]
        });
    }

    populate(room) {
        const votes = room.getCurrentRound().votes;
        const parsedData = {};
        for (let i = 0; i < votes.length; i++) {
            const voteLabel = room.type.getLabelForValue(votes[i].value);

            let newData = {};

            if (parsedData.hasOwnProperty(voteLabel) && parsedData[voteLabel]) {
                const oldData = parsedData[voteLabel];
                newData = {
                    numberOfVotes: oldData.numberOfVotes++,
                    label: oldData.label,
                    voters: oldData.voters + votes[i].voterName
                };
            } else {
                newData = {
                    numberOfVotes: 1,
                    label: voteLabel,
                    voters: votes[i].voterName
                };
            }

            parsedData[voteLabel] = newData;
        }

        const datapoints = [];
        for(var i = 0; i < Object.keys(parsedData).length; i++) {
            datapoints.push({
                y: parsedData[Object.keys(parsedData)[i]].numberOfVotes,
                label: parsedData[Object.keys(parsedData)[i]].label + ' (' + parsedData[Object.keys(parsedData)[i]].voters + ')'
            })
        }


        console.log(datapoints);

        this.chart.options.data[0].dataPoints = datapoints;
        this.chart.render();
    }

}

export default Pie;