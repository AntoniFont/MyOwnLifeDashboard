chart1Options = {

  title: {
    text: 'U.S Solar Employment Growth by Job Category, 2010-2020'
  },

  subtitle: {
    text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>'
  },

  xAxis: {
    tickInterval : 1
    
  },

  yAxis: {
    type: 'datetime',
    reversed: true,
    tickInterval: 24 * 3600,
    title: {
        text: 'Date'
    }
  },

  series: [/*{
    data: [
      [Date.parse('2016-10-20 03:14'), Date.parse('2016-10-20 03:14')],
      [Date.parse('2016-10-21 04:14'), Date.parse('2016-10-20 04:32')],
      [Date.parse('2016-10-22 12:14'), Date.parse('2016-10-20 05:34')]
    ],
    type: 'line'
  }*/
  {
    name:"Starting the day time",
    data: []
  },
  {
    name:"Last heard of at",
    data: []
  }
]
}