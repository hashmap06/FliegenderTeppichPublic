class ScrollHandler {
    constructor() {
        this.disableScroll();
    }

    disableScroll() {
        window.addEventListener('scroll', this.preventDefaultScroll);
    }

    preventDefaultScroll(event) {
        event.preventDefault();
    }
}

class WeekdayManager {
    constructor() {
        this.dayInt = this.getCurrentWochentagBerlin();
        this.wochentage = [1, 2, 3, 4, 5, 6, 7];
        this.umsortiert = this.umsortiereWochentage();
        this.wochentagsNamenArray = this.umwandelnInWochentagsNamen();
    }

    getCurrentWochentagBerlin() {
        const jetztInBerlin = new Date().toLocaleString("en-US", { timeZone: "Europe/Berlin" });
        const datumInBerlin = new Date(jetztInBerlin);
        let wochentag = datumInBerlin.getDay();
        if (wochentag === 0) {
            wochentag = 7;
        }
        return wochentag;
    }

    umsortiereWochentage() {
        if (this.dayInt >= 1 && this.dayInt <= 7) {
            const index = this.dayInt - 1;
            const teil1 = this.wochentage.slice(index + 1);
            const teil2 = this.wochentage.slice(0, index + 1);
            return teil1.concat(teil2);
        }
    }

    umwandelnInWochentagsNamen() {
        const wochentagsNamen = [
            "Montag",
            "Dienstag",
            "Mittwoch",
            "Donnerstag",
            "Freitag",
            "Samstag",
            "Sonntag"
        ];

        const wochentagsNamenArray = [];

        for (let i = 0; i < this.umsortiert.length; i++) {
            const wochentagsName = wochentagsNamen[this.umsortiert[i] - 1];
            wochentagsNamenArray.push(wochentagsName);
        }

        return wochentagsNamenArray;
    }

    umwandelnInWochentagsReihenfolge() {
        new mergeArrayInfosTogether(this.wochentagsNamenArray, this.umsortiert);
        return this.umsortiert;
    }
}

class mergeArrayInfosTogether {
    constructor(WochentageStringReihenfolge, ZahlenLogik) {
        console.log("New module: " + this.WochentageStringReihenfolge, this.ZahlenLogik);
    }
}

class DataProcessor {
    constructor(umsortiert) {
        this.umsortiert = umsortiert;
        this.nichtangemeldetValues = [];
        this.angemeldetValues = [];
        this.fetchData(this.umsortiert);
    }

    async fetchData(umsortiert) {
        try {
            const response = await fetch('../../db/database_handler/ClientServerSide_connect.php');
            const data = await response.json();
            this.wochentageArray = data;

            for (const key in this.wochentageArray) {
                if (key.endsWith('_Nichtangemeldet')) {
                    this.nichtangemeldetValues.push(this.wochentageArray[key]);
                }
            }

            for (const key in this.wochentageArray) {
                if (key.endsWith('_Angemeldet')) {
                    this.angemeldetValues.push(this.wochentageArray[key]);
                }
            }

            const [sortiertAngemeldet, sortiertNichtangemeldet] = this.secondFunction(
                this.nichtangemeldetValues,
                this.angemeldetValues,
                umsortiert
            );

            return [sortiertAngemeldet, sortiertNichtangemeldet];
        } catch (error) {
            console.error('Fehler:', error);
        }
    }

    secondFunction(nichtangemeldetValues, angemeldetValues, umsortiert) {
        const newSortedClickArrayNichtangemeldet = [];
        const newSortedClickArrayAngemeldet = [];

        for (const index of umsortiert) {
            const adjustedIndex = index - 1;

            if (adjustedIndex >= 0 && adjustedIndex < nichtangemeldetValues.length) {
                newSortedClickArrayNichtangemeldet.push(nichtangemeldetValues[adjustedIndex]);
            }

            if (adjustedIndex >= 0 && adjustedIndex < angemeldetValues.length) {
                newSortedClickArrayAngemeldet.push(angemeldetValues[adjustedIndex]);
            }
        }

        return [newSortedClickArrayAngemeldet, newSortedClickArrayNichtangemeldet];
    }
}

class ChartHandler {
    constructor(wochentagsNamenArray, nichtangemeldetValues, angemeldetValues) {
        this.createChart(wochentagsNamenArray, nichtangemeldetValues, angemeldetValues);
        console.log("FINAL METHOD CHECK ARRAY ACCESS: " + wochentagsNamenArray + nichtangemeldetValues + angemeldetValues);
    }

    createChart(labels, nichtangemedlet, angemeldet) {
        const data = {
            labels: labels,
            datasets: [{
                label: 'Seitenaufrufe',
                data: nichtangemedlet,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: false
            }, {
                label: 'Davon Angemeldete Nutzer',
                data: angemeldet,
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: false
            }]
        };

        const ctx = document.getElementById('clicksChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    stopScrolling = new ScrollHandler();
    stopScrolling;

    const weekDayManager = new WeekdayManager();
    const umsortiert = weekDayManager.umwandelnInWochentagsReihenfolge();
    const dataProcessor = new DataProcessor(umsortiert);

    dataProcessor.fetchData(umsortiert)
        .then(([angemeldet, nichtangemeldet]) => {
            new ChartHandler(weekDayManager.wochentagsNamenArray, nichtangemeldet, angemeldet);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});