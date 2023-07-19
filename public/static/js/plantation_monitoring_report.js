const canvas = document.getElementById('survival_rate');

if (canvas) {
    const graph_data = JSON.parse(document.getElementById('graph_data').value)

    let labels = graph_data.map(d => d.date_monitored);
    let data = graph_data.map(d => d.survival_rate)

    const survival_rate = new Chart(canvas, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Survival Rate',
                data: data,
                backgroundColor: 'rgb(108, 229, 232)',
                borderColor: 'rgb(108, 229, 232)',
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


    const values1 = graph_data.map(d => d.total_planted);
    const values2 = graph_data.map(d => d.no_survived);
    const values3 = graph_data.map(d => d.no_dead);
    const ctx = document.getElementById('planted_data').getContext('2d');
    const planted_data = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Planted',
                data: values1,
                backgroundColor: 'rgb(108, 229, 232)',
                borderColor: 'rgb(108, 229, 232)',
                borderWidth: 2
            },
            {
                label: 'No. Survived',
                data: values2,
                backgroundColor: 'rgb(65, 184, 213)',
                borderColor: 'rgb(65, 184, 213)',
                borderWidth: 2
            },
            {
                label: 'No. Dead',
                data: values3,
                backgroundColor: 'rgb(45, 139, 186)',
                borderColor: 'rgb(45, 139, 186)',
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
}



const manager_current_planted = document.getElementById('manager_current_planted');

if (manager_current_planted) {
    const graph_data = JSON.parse(document.getElementById('graph_data').value)

    let labels = graph_data.map(d => d.date_monitored);
    let data = graph_data.map(d => d.current_planted)

    const survival_rate = new Chart(manager_current_planted, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Current Planted',
                data: data,
                backgroundColor: 'rgb(108, 229, 232)',
                borderColor: 'rgb(108, 229, 232)',
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
                    title: {
                        display: true,
                        text: 'Current Planted',
                        font: {
                            size: 12,
                            lineHeight: 1.2,
                        },
                    },
                },
            }
        }
    })


    const values1 = graph_data.map(d => d.current_planted);
    const values2 = graph_data.map(d => d.no_dead);
    const values3 = graph_data.map(d => d.no_replanted);
    const ctx = document.getElementById('manager_planted_data').getContext('2d');
    const planted_data = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Planted',
                data: values1,
                backgroundColor: 'rgb(202, 242, 112)',
                borderColor: 'rgb(202, 242, 112)',
                borderWidth: 2,
                stack: "Stack 0"
            },
            {
                label: 'No. Dead',
                data: values2,
                backgroundColor: 'rgb(69, 196, 144)',
                borderColor: 'rgb(69, 196, 144)',
                borderWidth: 2,
                stack: "Stack 0"
            },
            {
                label: 'No. Replanted',
                data: values3,
                backgroundColor: 'rgb(0, 141, 147)',
                borderColor: 'rgb(0, 141, 147)',
                borderWidth: 2,
                stack: "Stack 0"
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
}