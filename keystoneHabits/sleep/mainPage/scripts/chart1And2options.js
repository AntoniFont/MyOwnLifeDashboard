chart1Options = {

  chart:{
    height: "70%",
    //width: 80
  },

  title: {
    text: 'Starting and ending the day time'
  },

  subtitle: {
    text: 'Subtitutlo'
  },

  xAxis: {
    tickInterval: 1

  },

  yAxis: {
    type: 'datetime',
    reversed: true,
    tickPixelInterval: 22,
    title: {
      text: 'Date'
    }
  },

  tooltip: {
    formatter: function () {
      return '<b>' + this.series.name + '</b><br/>' +
        Highcharts.dateFormat('%H:%M',
          new Date(this.y));
    }
  },

  series: [
    {
      name: "Starting the day time",
      data: []
    },
    {
      name: "Last heard of",
      data: []
    }
  ]
}

