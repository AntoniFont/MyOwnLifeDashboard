/*THESE VARIABLES CONTAIN ALL OF THE OPTIONS OF THE CHARTS, SUCH AS THE TITLE, THE SUBTITLE , THE NAME OF THE AXIS,
THE POINTER FORMAT, THE COLORS, ETC */

let chart2Options = {
    chart: {
        backgroundColor: "#FCFCF8",
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''//'¿Estas olvidando alguna asignatura?'
    },
    subtitle: {
        text: ''
    },
    tooltip: {
        pointFormat: '<b>{point.y} h</b><br><b>{point.percentage:.1f} %</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                overflow: "allow",
                enabled: true,
                format: '{point.name} <br> {point.percentage: .1f} % , {point.y} h'
            }
        }
    },
    series: [{
        name: 'Courses',
        colorByPoint: true,

        data: [], //TO BE FILLED
    }],

    drilldown: {
        series: [] //TO BE FILLED
    },
    credits: {
        enabled: false
    },

};

let chart6Options = {
    chart: {
        backgroundColor: "#FCFCF8",
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''//'¿Study routine breakdown?'
    },
    subtitle: {
        text: ''
    },
    tooltip: {
        pointFormat: '<b>{point.y} h</b><br><b>{point.percentage:.1f} %</b> <br>{point.description}'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                overflow: "allow",
                enabled: true,
                format: '{point.name} <br> {point.percentage: .1f} % , {point.y} h'
            }
        }
    },
    series: [{
        name: 'Triggers',
        data: [], //TO BE FILLED
    }],
    credits: {
        enabled: false
    },

};


let chart7Options = {
    chart: {
        backgroundColor: "#FCFCF8",
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'column'
    },
    title: {
        text: ' '
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        visible: false
    },
    yAxis: {
        title: "Numero de horas",
        visible: true
    },
    tooltip: {
        pointFormat: '<b>{point.y} h</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        column: {
            allowPointSelect: true,
            dataLabels: {
                enabled: true,
                format: '{point.y} h'
            },
            dataSorting: {
                enabled: true
            },
        }
    },
    series: [{
        name: 'Triggers',
        colorByPoint: true,
        data: [], //TO BE FILLED
        legendType: "point"
    }],
    credits: {
        enabled: false
    },

};



let chart1Options = {
    chart: {
        backgroundColor: "#FCFCF8",
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'column'
    },
    title: {
        text: ' '
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        visible: false
    },
    yAxis: {
        title: "Numero de horas",
        visible: true
    },
    tooltip: {
        pointFormat: '<b>{point.y} h</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        column: {
            allowPointSelect: true,
            dataLabels: {
                enabled: true,
                format: '{point.y} h'
            },
            dataSorting: {
                enabled: true
            },
        }
    },
    series: [{
        name: 'Courses',
        colorByPoint: true,
        data: [], //TO BE FILLED
        legendType: "point"
    }],
    credits: {
        enabled: false
    },
    drilldown: {
        dataSorting: {
            enabled: true
        },
        /*activeDataLabelStyle: { TO REMOVE THE UNDERLINE UNCOMMENT THIS
            textDecoration: "none",
            color: "#000000"
        }*/
        series: [] //TO BE FILLED
    }

};

let chart3Options = {

    chart: {
        backgroundColor: "#FCFCF8"
    },
    title: {
        text: 'Percentage of baseline completed, by day'
    },
    subtitle: {
        text: "Time greater than the baseline is displayed as 100%"
    },

    xAxis: {
        type: 'datetime',
        tickInterval: 24 * 3600 * 1000,
        title: {
            text: 'Date'
        }
    },
    yAxis: {
        title: {
            enabled: false
        },
        ceiling: 100,
        floor: 0
    },

    legend: {
        enabled: false,
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            }
        }
    },

    series: [{
        name: 'Percentage of baseline completed',
        data: []
    }],
    credits: {
        enabled: false
    }

};

let chart5Options= {
    chart: {
        type: 'solidgauge',
        //backgroundColor: 'transparent', 
        margin: [0, 0, 0, 0],
        spacing: [0, 0, 0, 0],
        height: "50%",
    },
    
    title: null,
    
    pane: {
        center: ['50%', '50%'],
        size: '100%',
        startAngle: 0,
        endAngle: 360,
        background: null,
        /*background: {
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
            innerRadius: '60%',
            outerRadius: '100%',
            //shape: 'arc',
        },*/
    },
    
    tooltip: {
        enabled: false,
    },
    
    yAxis: {
        stops: [
            [0.33, '#DF5353'], // Red
            [0.66, '#DDDF0D'], // Yellow
            [0.99, '#55BF3B'], // Green
        ],
        minorTickInterval: null,
        min: 0,
        max: 100,
    },
    
    plotOptions: {
        solidgauge: {
            dataLabels: {
                y: -25,
                borderWidth: 0,
                useHTML: true,
            },
        },
    },
    
    credits: {
        enabled: false,
    },
    
    series: [
        {
            name: 'Speed',
            data: [80], // The data point value
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:black">{y}%</span><br/>' +
                    '<span style="font-size:10px;color:silver">Porcentaje diario crítico completado</span></div>',
            },
        },
    ],
}