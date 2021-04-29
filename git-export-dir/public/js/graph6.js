(function($){
"use strict";
var myChart = echarts.init(document.getElementById('graph06'), 'azul');
var option = {
  tooltip: {
      trigger: 'item',
      formatter: '{a} <br/>{b}: {c} ({d}%)'
  },
  legend: {
      orient: 'vertical',
      left: 10,
      data: ['Pending', 'Won', 'Dead', 'Poorfit']
  },
  series: [
      {
          name: 'Lead Stats',
          type: 'pie',
          radius: ['45%', '70%'],
          avoidLabelOverlap: false,
          label: {
              show: false,
              position: 'center'
          },
          emphasis: {
              label: {
                  show: true,
                  fontSize: '20',
                  fontWeight: 'bold'
              }
          },
          labelLine: {
              show: true
          },
          data: [
              {value: g6_poorfit_leads, name: 'Dead'},
              {value: g6_pending_leads, name: 'Pending'},
              {value: g6_won_leads, name: 'Won'},
              {value: g6_dead_leads, name: 'Poorfit'},
          ]
      }
    ]
};
// use configuration item and data specified to show chart
myChart.setOption(option);
})(jQuery);