const canvas = document.getElementById('survival_rate');
const survival_rates_data = JSON.parse(document.getElementById('survival_rates').value)

let labels = survival_rates_data.map(d => d.date_monitored);
let data = survival_rates_data.map(d => d.survival_rate)

const survival_rate = new Chart(canvas, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Survival Rate',
            data: data,
            backgroundColor: 'rgba(177, 138, 255, 0.2)',
            borderColor: 'rgb(177, 138, 255)',
            borderWidth: 2
        }]
    },
    options: {
        plugins: {
            legend: {
                display: true
            },
        },
        responsive: true,
        scales: {
            x: {
                display: true,
                offset: true,
                title: {
                    display: true,
                    text: 'Date Monitored',
                    font: {
                        size: 12,
                        lineHeight: 1.2,
                    },
                },
            },
            y: {
                display: true,
                min: 0,
                max: 100,
                title: {
                    display: true,
                    text: 'Survival Rate (%)',
                    font: {
                        size: 12,
                        lineHeight: 1.2,
                    },
                },
            },
        }
    }
})

const no_planted_data = JSON.parse(document.getElementById('no_planted_data').value);

console.log(no_planted_data);

const labels_planted_data = no_planted_data.map(d => d.unique_code);
const values1 = no_planted_data.map(d => d.target_no);
const values2 = no_planted_data.map(d => d.current_planted);
const ctx = document.getElementById('planted_data').getContext('2d');
const planted_data = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels_planted_data,
        datasets: [{
            label: 'Target Number',
            data: values1,
            backgroundColor: 'rgb(108, 229, 232)',
            borderColor: 'rgb(108, 229, 232)',
            borderWidth: 2
        },
        {
            label: 'Current Number',
            data: values2,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2
        }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            }
        },
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Plantation Unique Code',
                    font: {
                        size: 12,
                        lineHeight: 1.2,
                    },
                    padding: { top: 10, left: 0, right: 0, bottom: 0 }
                }
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: 'Planted Values',
                    font: {
                        size: 12,
                        lineHeight: 1.2,
                    },
                    padding: { top: 0, left: 0, right: 0, bottom: 2 }
                }
            },
        }
    }
});

