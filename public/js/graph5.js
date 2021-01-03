(function($){
"use strict";
    // based on prepared DOM, initialize echarts instance
    var myChart = echarts.init(document.getElementById('graph05'), 'azul');
    var avg_data = [];
    monthly_leads_avg.forEach(element => {
      element = element.toFixed(2);
      avg_data.push(element)
    });

    var option = {
        title: {
            text: 'Leads Avg Report ',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: '{b} : {c}%'
        },
        legend: {
            bottom: 10,
            left: 'center',
        },
        xAxis: {
            type: 'category',
            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: avg_data,
            type: 'bar',
            showBackground: true,
            backgroundStyle: {
                color: 'rgba(220, 220, 220, 0.8)'
            }
        }]
    };
    // use configuration item and data specified to show chart
    myChart.setOption(option);
})(jQuery);