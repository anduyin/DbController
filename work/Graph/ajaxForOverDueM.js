var myChart = echarts.init(document.getElementById('main'));
var app = {};
option = null;

if (option && typeof option === "object") {
    myChart.setOption(option, true);
}

// 异步加载数据
$.get('../outAjax.php').done(function (data) {

    var obj = JSON.parse(data);
    //M1O, M20, M3O
    var m1oData = [];
    var m2oData = [];
    var m3oData = [];

    //设置loanNames的对象
    Object.keys(obj.loanNames).forEach(function (key, index) {
        var value = obj.loanNames[key];
        m1oData[value] = [value];
        m2oData[value] = [value];
        m3oData[value] = [value];
    });

    //时间轴
    var xtime = [];
    Object.keys(obj.loanTable).forEach(function (key, index) {
        xtime.push(key);
        var arr1 = obj.loanTable[key]['M1O'];
        var arr2 = obj.loanTable[key]['M2O'];
        var arr3 = obj.loanTable[key]['M3O'];

        //数据要等长，循环mxoData的，根据arr填入相应的值，没有就用-代替
        //M1O
        Object.keys(m1oData).forEach(function (k, i) {
            if (arr1.hasOwnProperty(k)) {
                var value = arr1[k];
                m1oData[k].push(value);
            } else {
                m1oData[k].push('-');
            }
        });

        //M2O
        Object.keys(m2oData).forEach(function (k, i) {
            if (arr2.hasOwnProperty(k)) {
                var value = arr2[k];
                m2oData[k].push(value);
            } else {
                m2oData[k].push(0);
            }
        });

        //M3O
        Object.keys(m3oData).forEach(function (k, i) {
            if (arr3.hasOwnProperty(k)) {
                var value = arr3[k];
                m3oData[k].push(value);
            } else {
                m3oData[k].push(0);
            }
        });
    });


    //通过获取页面的标识选择返回m1,m2,m3逾期率的哪一个
    var show = $("#msign").attr('value');
    //对应显示的M1, M2, M3的逾期率
    var showType = {
        "m1o": [m1oData, "M1"],
        "m2o": [m2oData, "M2"],
        "m3o": [m3oData, "M3"]
    };

    var data = Object.values(showType[show][0]);
    var product = ['product'].concat(xtime);

    //下面生成给echarts的option用的变量
    var source = [product].concat(data);
    var series = [];
    for (var i = 0; i < data.length; i++) {
        series.push(
            {
                type: 'line',
                seriesLayoutBy: 'row',
                smooth: true
            }
        );
    }

    // 填入数据
    option = {
        title: {
            text: showType[show][1] + '逾期率'
        },
        legend: {
            type: 'scroll'
        },
        toolbox: {
            show: true,
            feature: {
                mark: { show: true },
                magicType: { show: true, type: ['line'] },
                restore: { show: true },
                saveAsImage: { show: true }
            }
        },
        calculable: true,
        tooltip: {
            trigger: 'axis'
        },
        xAxis: [
            {
                type: 'category',
            }
        ],
        yAxis: [
            {
                type: 'value'
            }
        ],
        dataset: {
            source: source
        },
        // Declare several bar series, each will be mapped
        // to a column of dataset.source by default.
        series: series
    };

    myChart.setOption(option);
});