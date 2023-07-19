const canvas = document.getElementById('survival_rates');
const batch_monitorings_data = JSON.parse(document.getElementById('batch_monitorings').value)

let labels = batch_monitorings_data.map(d => d.date_monitored);
let data = batch_monitorings_data.map(d => d.survival_rate)

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
                display: true, 
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

console.log(batch_monitorings_data);
const values1 = batch_monitorings_data.map(d => d.current_no_potted);
const values2 = batch_monitorings_data.map(d => d.no_survived);
const values3 = batch_monitorings_data.map(d => d.no_dead);
const ctx = document.getElementById('potted_data').getContext('2d');
const planted_data = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Current Number',
            data: values1,
            backgroundColor: 'rgb(0, 173, 181)',
            borderColor: 'rgb(0, 173, 181)',
            borderWidth: 2
        },
        {
            label: 'Survived',
            data: values2,
            backgroundColor: 'rgb(143, 172, 106)',
            borderColor: 'rgb(143, 172, 106)',
            borderWidth: 2
        },
        {
            label: 'Dead',
            data: values3,
            backgroundColor: 'rgb(34, 40, 49)',
            borderColor: 'rgb(34, 40, 49)',
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
                    text: 'Date Monitored',
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

