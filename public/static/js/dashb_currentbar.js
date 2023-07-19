fetch('/graph/plantation-planted')
    .then(response => response.json())
    .then(data => {
        const labels = data.map(d => d.unique_code);
        const values1 = data.map(d => d.target_no);
        const values2 = data.map(d => d.current_planted);
        const ctx = document.getElementById('planted_data').getContext('2d');
        const planted_data = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Target Number to be Planted',
                    data: values1,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                },
                {
                    label: 'Current Number Planted',
                    data: values2,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }
                ]
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
    });

