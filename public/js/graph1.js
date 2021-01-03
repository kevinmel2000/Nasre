(function($){
"use strict";
    // based on prepared DOM, initialize echarts instance
    var myChart = echarts.init(document.getElementById('graph01'), 'westeros');
    var  option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {            
                type: 'shadow'        
            }
        },
        legend: {
            data: ['Total','Pending','Won','Dead','Poorfit']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name: 'Total',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true,
                    position: 'insideRight'
                },
                data: m_total_leads
            },
            {
                name: 'Pending',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true,
                    position: 'insideRight'
                },
                data: m_pending_leads
            },
            {
                name: 'Won',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true,
                    position: 'insideRight'
                },
                data: m_won_leads
            },
            {
                name: 'Dead',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true,
                    position: 'insideRight'
                },
                data: m_dead_leads
            },
            {
                name: 'Poorfit',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true,
                    position: 'insideRight'
                },
                data: m_poorfit_leads
            }
        ]
    };
    myChart.setOption(option);
})(jQuery);