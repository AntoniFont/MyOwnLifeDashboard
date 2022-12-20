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