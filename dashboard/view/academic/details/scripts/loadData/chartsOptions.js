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

