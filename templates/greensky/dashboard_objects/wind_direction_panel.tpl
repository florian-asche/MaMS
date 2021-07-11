<script type="text/javascript" src="highchart/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="highchart/highcharts.js"></script>
<script type="text/javascript" src="highchart/highcharts-more.js"></script>
<script type="text/javascript" src="livedata.php"></script>
<script type="text/javascript">
$(function () {
        var langWindDir = new Array("N", "NNE", "NE", "ENE","E", "ESE", "SE", "SSE","S", "SSW", "SW", "WSW","W", "WNW", "NW", "NNW");
        function windDirLang ($winddir)
        {
                /* return langWindDir[Math.floor(((parseInt($winddir) + 11) / 22.5) % 16 )];*/
                return langWindDir[Math.floor(((parseInt($winddir) + 11.25) / 22.5))];
        }
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Wind Direction'
            },
            credits: {
                                enabled: false
                },
                pane: {
                /* startAngle: -180, */
                /* endAngle: 180, */
                background: [{
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 1,
                    outerRadius: '107%'
                }, {
                    // default background
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0,
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
            },
            // the value axis
            yAxis: {
                min: 0,
                max: 360,
               
                /* minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#666', */
       
                tickPixelInterval: 30,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 3,
                tickColor: '#666',
                labels: {
                    step: 2,
                    rotation: 'auto',
                                formatter:
                                function() {
                                        return windDirLang(this.value);
                                },
                },
                /* title: {
                    text: 'km/h'
                }, */
                /* plotBands: [{
                    from: 0,
                    to: 60,
                    color: '#55BF3B' // green
                }, {
                    from: 60,
                    to: 80,
                    color: '#DDDF0D' // yellow
                }, {
                    from: 80,
                    to: 180,
                    color: '#DF5353' // red
                }] */      
            },
            series: [{
                name: 'Dir',
                data: [0],
                tooltip: {
                    /* valueSuffix: ' km/h' */
                                enabled: false
                }
            }]
        },
        function (chart) {
        setInterval(function() {
        $(function() {
        $.getJSON('livedata.php', function(data) {
            $.each(data, function(key,val) {
            if (key == 'WindDir')
            {
                                var point = chart.series[0].points[0];
                point.update(val);
            }
            });
        });
        })
    },2000)
    })
});
</script>
</head>
<body>
<div id="container" style="width: 250px; height: 250px; margin: 0 auto"></div>
</body>