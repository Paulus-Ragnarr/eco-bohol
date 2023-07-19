fetch('/graph/survival-rate')
    .then(response => response.json())
    .then(data => {
        const labels = data.map(d => d.unique_code);
        
        let survival_rates = []

        for (let i = 0; i < data.length; i++) {
            survival_rates.push(data[i].officer_monitorings[0] ? data[i].officer_monitorings[0].survival_rate : 0)
        }

        console.log(survival_rates)
        const canvas = document.getElementById('survival_rate');
        const survival_rate = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Survival Rate',
                    data: survival_rates,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Plantation Unique Code',
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
                            text: 'Survival Rate (%)',
                            color: 'rgb(19, 155, 69)',
                            font: {
                                size: 16,
                                weight: 'bold',
                                lineHeight: 1.2,
                            },
                            padding: { top: 0, left: 0, right: 0, bottom: 2 }
                        },
                        ticks: {
                            format: {
                                min: 0,
                                max: 100,
                                stepSize: 20,
                                callback: function (value) {
                                    return (value / this.max * 100).toFixed(0) + '%'; // convert it to percentage
                                },

                            }
                        },
                    },
                }
            }
        })
    });








