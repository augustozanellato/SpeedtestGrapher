window.onload = function() {
    var ctx = document.getElementById('graph').getContext('2d');
    window.myLine = Chart.Line(ctx, {
        data: speedtestData,
        options: {
            responsive: true,
            hoverMode: 'index',
            stacked: false,
            scales: {
                yAxes: [{
                    type: 'linear',
                    display: true,
                    position: 'left',
                    id: 'y-axis-speed',
                }, {
                    type: 'linear', 
                    display: true,
                    position: 'right',
                    id: 'y-axis-latency',

                    gridLines: {
                        drawOnChartArea: false,
                    },
                }],
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: "YYYY-MM-DD HH:mm:ss"
                    }
                }]
            },
            plugins: {
                zoom: {
                    pan: {
                        enabled: true, 
                        mode: 'x'
                    },
                    zoom: {
                        enabled: true,
                        mode: 'x',
                        speed: 0.1
                    }
                }
            }
        }
    });
};