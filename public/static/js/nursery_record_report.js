const canvas = document.getElementById('batch_survival_rate');
const latest_records_data = JSON.parse(document.getElementById('latest_records').value)

let labels = latest_records_data.map(d => d.species);
let data = latest_records_data.map(d => d.survival_rate)

const survival_rate = new Chart(canvas, {
    type: 'bar',
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
                    text: 'Species',
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

console.log(latest_records_data);
const values1 = latest_records_data.map(d => d.current_no_potted);
const ctx = document.getElementById('propagule_data').getContext('2d');
const planted_data = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Current Number Planted',
            data: values1,
            backgroundColor: 'rgb(108, 229, 232)',
            borderColor: 'rgb(108, 229, 232)',
            borderWidth: 2
        }]
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
                    text: 'Species',
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
                    text: 'Potted Values',
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

