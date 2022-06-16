define(['jquery', 'bootstrap', 'backend', 'addtabs', 'table', 'echarts', 'echarts-theme', 'template','odometer','layui'], function ($, undefined, Backend, Datatable, Table, Echarts, undefined, Template , odometer , layui) {


    var Controller = {
        index: function () {
            // 基于准备好的dom，初始化echarts实例
            var myChart = Echarts.init(document.getElementById('echart'), 'walden');
            var myCharts = Echarts.init(document.getElementById('echart2'), 'walden');

            // 指定图表的配置项和数据
            var option = {
                title: {
                    text: '',
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: [__('Sales'), __('Orders'),__('failure')]
                },
                toolbox: {
                    show: false,
                    feature: {
                        magicType: {show: true, type: ['stack', 'tiled']},
                        saveAsImage: {show: true}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: Orderdata.column
                },
                yAxis: {},
                grid: [{
                    left: '30',
                    top: '20',
                    right: '10',
                    bottom: 30
                }],
                series: [{
                    name: __('Sales'),
                    type: 'line',
                    smooth: true,
                    areaStyle: {
                        normal: {}
                    },
                    lineStyle: {
                        normal: {
                            width: 1.5
                        },
                    },
                    data: Orderdata.paydata
                },
                    {
                        name: __('Orders'),
                        type: 'line',
                        smooth: true,
                        areaStyle: {
                            normal: {}
                        },
                        lineStyle: {
                            normal: {
                                width: 1.5
                            }
                        },
                        data: Orderdata.createdata
                    }/*,
                    {
                        name: __('failure'),
                        type: 'line',
                        smooth: true,
                        areaStyle: {
                            normal: {}
                        },
                        lineStyle: {
                            normal: {
                                width: 1.5
                            }
                        },
                        label: {
                            color: "rgba(17, 222, 137, 1)"
                        },
                        data: Orderdata.failure
                    }*/]
            };
            var option1 = {
                title: {
                    text: '',
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['访问量']
                },
                toolbox: {
                    show: false,
                    feature: {
                        magicType: {show: true, type: ['stack', 'tiled']},
                        saveAsImage: {show: true}
                    }
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data: Orderdata.hour_key
                },
                yAxis: {},
                grid: [{
                    left: '30',
                    top: '20',
                    right: '10',
                    bottom: 30
                }],
                series: [{
                    name: '访问量',
                    type: 'line',
                    smooth: true,
                    areaStyle: {
                        normal: {}
                    },
                    lineStyle: {
                        normal: {
                            width: 1.5
                        },
                    },
                    data: Orderdata.hour
                }]
            };

            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
            myCharts.setOption(option1);

            //动态添加数据，可以通过Ajax获取数据然后填充
            setInterval(function () {

                Orderdata.column.push((new Date()).toLocaleTimeString().replace(/^\D*/, ''));

                $.getJSON("/admin/order/getOrderCount", function (e) {
                    Orderdata.createdata.push(e.createdata);
                    Orderdata.paydata.push(e.paydata);
                    Orderdata.hour.push(e.hour);
                    Orderdata.hour_key.push(e.hour_key);
                   // Orderdata.failure.push(e.failure);
                });
                //var amount = Math.floor(Math.random() * 200) + 20;

                //按自己需求可以取消这个限制
                if (Orderdata.column.length >= 20) {
                    //移除最开始的一条数据
                    Orderdata.column.shift();
                    Orderdata.paydata.shift();
                    Orderdata.createdata.shift();
                    Orderdata.hour.shift();
                    Orderdata.hour_key.shift();
                   // Orderdata.failure.shift();
                }
                myChart.setOption({
                    xAxis: {
                        data: Orderdata.column
                    },
                    series: [{
                        name: __('Sales'),
                        data: Orderdata.paydata
                    },
                        {
                            name: __('Orders'),
                            data: Orderdata.createdata
                        }/*,
                        {
                            name: __('failure'),
                            data: Orderdata.failure
                        }*/]
                });
                myCharts.setOption({
                    xAxis: {
                        data: Orderdata.hour_key
                    },
                    series: [{
                        name: '访问量',
                        data: Orderdata.hour
                    }]
                });
            }, 2000);
            $(window).resize(function () {
                myChart.resize();
                myCharts.resize();
            });

            $(document).on("click", ".btn-checkversion", function () {
                top.window.$("[data-toggle=checkupdate]").trigger("click");
            });

            $(document).on("click", ".btn-refresh", function () {
                setTimeout(function () {
                    myChart.resize();
                }, 0);
            });
            $(document).on('click','.mjum',function(){
                //location.href = $(this).attr('lay-url')+"?ref=addtabs";

                Backend.api.addtabs($(this).attr('lay-url'));
            })

            //数字变更
            $(document).ready(function(){
                var odo1 = new Odometer('#totalorder',{
                    num : total.totalorder
                });

                var odo2 = new Odometer('#totalorderamount',{
                    num : total.totalorderamount
                });

                var odo3 = new Odometer('#totalviews',{
                    num : total.totalviews
                });

                var todayUserAccessCount = new Odometer('#todayUserAccessCount',{
                    num : total.todayUserAccessCount
                });

                var toDayOrder = new Odometer('#toDayOrder',{
                    num : total.toDayOrder
                });

                var toDaySuccessOrder = new Odometer('#toDaySuccessOrder',{
                    num : total.toDaySuccessOrder
                });

                var toDayFailureOrder = new Odometer('#toDayFailureOrder',{
                    num : total.toDayFailureOrder
                });


                    var toDayKouliang = new Odometer('#toDayKouliang',{
                        num : total.toDayKouliang
                    });



                var yesterdayAccessCount = new Odometer('#yesterdayAccessCount',{
                    num : total.yesterdayAccessCount
                });

                var yesterdayMoney = new Odometer('#yesterdayMoney',{
                    num : total.yesterdayMoney
                });
                var toDayMoney = new Odometer('#toDayMoney',{
                    num : total.toDayMoney
                });
                //自动刷新
                setInterval(function(){
                    $.getJSON("/admin/dashboard?ajax=1", function (e) {
                        //总访问数
                        odo3.update(e.data.totalviews);
                        //总订单数
                        odo1.update(e.data.totalorder);
                        //余额
                        odo2.update(e.data.totalorderamount);
                        todayUserAccessCount.update(e.data.todayUserAccessCount);
                        toDayOrder.update(e.data.toDayOrder);
                        toDaySuccessOrder.update(e.data.toDaySuccessOrder);
                        toDayFailureOrder.update(e.data.toDayFailureOrder);

                        toDayKouliang.update(e.data.toDayKouliang);
                        yesterdayAccessCount.update(e.data.yesterdayAccessCount);
                        yesterdayMoney.update(e.data.yesterdayMoney);
                        toDayMoney.update(e.data.toDayMoney);
                    });
                },3000);
            });
        }
    };

    return Controller;
});