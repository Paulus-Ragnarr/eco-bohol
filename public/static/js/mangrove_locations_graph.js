const data = JSON.parse(document.getElementById('mangrove_locations').value);
const labels = data.map(d => d.town);
const values1 = data.map(d => d.plantation);
const values2 = data.map(d => d.naturally_grown);
const ctx = document.getElementById('location_graph').getContext('2d');
const planted_data = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Plantation',
            data: values1,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            // stack: "0"
        },
        {
            label: 'Naturally Grown',
            data: values2,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            // stack: "0"
        },
        ]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Town',
                    color: 'rgb(19, 155, 69)',
                    font: {
                        size: 15,
                        weight: 'bold',
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
                    color: 'rgb(19, 155, 69)',
                    font: {
                        size: 16,
                        weight: 'bold',
                        lineHeight: 1.2,
                    },
                    padding: { top: 0, left: 0, right: 0, bottom: 2 }
                }
            },
        }
    }
});