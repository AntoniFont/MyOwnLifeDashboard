/*THESE VARIABLES CONTAIN ALL OF THE OPTIONS OF THE CHARTS, SUCH AS THE TITLE, THE SUBTITLE , THE NAME OF THE AXIS,
THE POINTER FORMAT, THE COLORS, ETC0 */

let chart2Options =  {
    chart: {
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
    credits: {
        enabled: false
      },
    
};

let chart1Options =  {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'column'
    },
    title: {
        text: ' '
    },
    subtitle: {
        text: ' '
    },
    xAxis: {
        visible : false
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
            }
        }
    },
    series: [{
        name: 'Courses',
        colorByPoint: true,
        data: [], //TO BE FILLED
        dataSorting: {
            enabled:  true
        },
        legendType: "point"
    }],
    credits: {
        enabled: false
      },
    
};

let chart3Options = {

    title: {
        text: 'U.S Solar Employment Growth by Job Category, 2010-2020'
    },

    subtitle: {
        text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>'
    },

    xAxis: {
        type: 'datetime',
        tickInterval: 24 * 3600 * 1000 ,
        //startOnTick: true,
     //endOnTick: true,
        /*dateTimeLabelFormats: { // don't display the year
            day: '%e. %b',
            week: '%e. %b',
            month: '%e. %b',
        },*/
        title: {
            text: 'Date'
        }
    },
    yAxis: {
        title: {
            text: 'Number of Employees'
        }
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            }
        }
    },

    series: [{
        name: 'Installation & Developers',
        data: []
    }],

    /*responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }*/

};
        