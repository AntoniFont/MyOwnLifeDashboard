let chart1Options =  {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: '¿Estas olvidando alguna asignatura?'
    },
    subtitle: {
        text: 'Cantidad de horas por asignatura de las últimas 2 semanas'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                enabled: true,
                format: '<b>{point.name}</b>:{point.percentage:.1f} %<br>{point.y} horas'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [] //TO BE FILLED
    }]
};