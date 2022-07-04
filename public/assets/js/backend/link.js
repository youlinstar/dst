
define(['jquery', 'bootstrap', 'backend', 'table', 'form','qr','bootstrap-table-fixed-columns'], function ($, undefined, Backend, Table, Form,qr,fixedType) {

    var layer = layui.layer;
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'link/index' + location.search,
                    add_url: 'link/add',
                    edit_url: 'link/edit',
                    del_url: 'link/del',
                    multi_url: 'link/multi',
                    table: 'link',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                fixedColumns:false,
                fixedNumber:1,
                fixedNumberWidth:115,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'title', title: __('Title')},
                        {field: 'category.name', title: __('Category.name')},
                        {
                            field: 'img',
                            title: __('Img'),
                            operate: false,
                            events: Table.api.events.image,
                            formatter: Table.api.formatter.image
                        },
                        {field: 'money', title: __('Money'), operate: 'BETWEEN'},
                        {
                            field: 'money1',
                            title: __('Money1'),
                            operate: 'BETWEEN'
                        },
                        {field: 'money2', title: __('Money2'), operate: 'BETWEEN'},
                        {field: 'money3', title: '包周金额' ,operate: 'BETWEEN'},
                        /*{
                            field: 'mianfei',
                            title: __('Mianfei'),
                            formatter: function (value, row) {
                                if (value == 1) {
                                    return "<span class=\"label label-danger\">免费</span>"
                                }
                                if (value == 0) {
                                    return "<span class=\"label label-success\">不免费</span>"

                                }
                            }
                        },*/

                        {field: 'read_num', title: __('Read_num')},
                        {field: 'try_see', title: __('try_see')},
                        /* {
                             field: 'status',
                             title: __('Status'),
                             formatter: function (value , row) {
                                 if (value == 2) {
                                     return "<span class=\"label label-danger\">警用</span>"
                                 }
                                 if (value == 1) {
                                     return "<span class=\"label label-success\">启用</span>"
                                 }
                             }
                         },*/

                        /*{
                            field: 'is_top',
                            title: "是否置顶",
                            formatter: function (value, row) {
                                if (value == 1) {
                                    return "<span class=\"label label-danger\">置顶</span>";
                                }
                                if (value == 0) {
                                    return "<span class=\"label label-success\">否</span>";

                                }
                            }
                        },*/
                        {
                            field: 'is_top',
                            title: "是否置顶",
                            align: 'center',
                            visible:userinfo.id===1,
                            cardVisible:userinfo.id===1,
                            switchable:userinfo.id===1,
                            formatter: Table.api.formatter.toggle
                        },
                        {
                            field: 'over_time',
                            title: __('Over_time'),
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            formatter: Table.api.formatter.datetime
                        },
                        {
                            field: 'input_time',
                            title: __('Input_time'),
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            formatter: Table.api.formatter.datetime
                        },
                        /* {field: 'stock_id', title: __('Stock_id')},
                         {field: 'tuiguanged', title: __('Tuiguanged')},
                         {field: 'try_see', title: __('Try_see')},*/

                        {
                            field: 'operate',
                            buttons: [
                                {
                                    name: 'label',
                                    title:"播放",
                                    // text: "播放",
                                    icon: 'fa fa-youtube-play',
                                    classname: 'btn btn-xs btn-info btn-click ',
                                    extend:"data-toggle=\"tooltip\"",
                                    click:function(config , row){
                                        Controller.api.play(this ,false ,  row);
                                    },
                                },
                                {
                                    name: 'label',
                                    title:"url短链接",
                                    // text: "播放",
                                    icon: 'fa fa-chain',
                                    classname: 'btn btn-xs btn-primary btn-click',
                                    extend:"data-toggle=\"tooltip\"",
                                    click:function(config , row){
                                        Controller.api.short(this , false ,  row);
                                    },
                                },
                                /*{
                                    name: 'label',
                                    title:"置顶",
                                    icon: 'fa fa-unsorted',
                                    classname: 'btn btn-xs btn-primary btn-click',
                                    extend:"data-toggle=\"tooltip\"",
                                    click:function(config , row){
                                        //Controller.api.short(this , false ,  row);
                                        Controller.api.setTop(this  ,  row);
                                    },
                                }*/

                            ],
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate
                        },
                    ]
                ]
            });


            // 为表格绑定事件
            Table.api.bindevent(table);

            //批量修改金额
            $(".editMoney").click(function () {
                addoredit("link/changemoney", '批量修改金额');
            });
            //批量试看
            $(".trySee").click(function () {
                addoredit("link/trySee", '批量修改试看时间【秒】 0为关闭');
            });
            //包日价格
            $(".dateFee").click(function () {
                    var laydate = layer;
                    var fee = 0;
                    var dateFee = userinfo.date_fee;
                    var index = laydate.prompt({
                        title: '包日金额设置 范围(0-188)【设置0为关闭包天功能】',
                        value: dateFee,
                        formType: 3
                    }, function (fee, index) {
                        if (fee < 0 || fee > 188) {
                            if (fee > 0) {
                                if (fee < 0 || fee > 188) {
                                    alert('错误：包日价格范围需在0-188，请重新设置！');
                                    return;
                                }
                            } else if
                            (fee < 0) {
                                alert('错误：金额不能小于0');
                                return;
                            }
                        }

                        $.ajax({
                            url: "link/dateFee",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                fee: fee
                            },
                            success: function (res) {
                                layer.close(index);
                                if (res.code == 0) {
                                    layer.msg(res.msg, {icon: 1, time: 1000, shade: 0.1}, function () {
                                        window.location.reload();
                                    });
                                } else {
                                    layer.msg(res.msg, {icon: 0, time: 1500, shade: 0.1}, function () {
                                    });
                                }
                                // console.log(data);
                            }
                        });
                    });


            });
            
            //包周价格
            $(".weekFee").click(function () {
                    var laydate = layer;
                    var fee = 0;
                    var dateFee = userinfo.week_fee;
                    var index = laydate.prompt({
                        title: '包周金额设置 范围(0-188)【设置0为关闭包天功能】',
                        value: dateFee,
                        formType: 3
                    }, function (fee, index) {
                        if (fee < 0 || fee > 188) {
                            if (fee > 0) {
                                if (fee < 0 || fee > 188) {
                                    alert('错误：包周价格范围需在0-188，请重新设置！');
                                    return;
                                }
                            } else if
                            (fee < 0) {
                                alert('错误：金额不能小于0');
                                return;
                            }
                        }

                        $.ajax({
                            url: "link/weekFee",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                fee: fee
                            },
                            success: function (res) {
                                layer.close(index);
                                if (res.code == 0) {
                                    layer.msg(res.msg, {icon: 1, time: 1000, shade: 0.1}, function () {
                                        window.location.reload();
                                    });
                                } else {
                                    layer.msg(res.msg, {icon: 0, time: 1500, shade: 0.1}, function () {
                                    });
                                }
                                // console.log(data);
                            }
                        });
                    });


            });
            
            //包月价格
            $(".monthFee").click(function () {
                    var laydate = layer;
                    var fee = 0;
                    var dateFee = userinfo.date_fee;
                    var index = laydate.prompt({
                        title: '包月金额设置 范围(0-188)【设置0为关闭包月功能】',
                        value: dateFee,
                        formType: 3
                    }, function (fee, index) {
                        if (fee < 0 || fee > 188) {
                            if (fee > 0) {
                                if (fee < 0 || fee > 188) {
                                    alert('错误：包月价格范围需在0-188，请重新设置！');
                                    return;
                                }
                            } else if
                            (fee < 0) {
                                alert('错误：金额不能小于0');
                                return;
                            }
                        }

                        $.ajax({
                            url: "link/monthfee",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                fee: fee
                            },
                            success: function (res) {
                                layer.close(index);
                                if (res.code == 0) {
                                    layer.msg(res.msg, {icon: 1, time: 1000, shade: 0.1}, function () {
                                        window.location.reload();
                                    });
                                } else {
                                    layer.msg(res.msg, {icon: 0, time: 1500, shade: 0.1}, function () {
                                    });
                                }
                                // console.log(data);
                            }
                        });
                    });
            });

            //获取推广总链
            $(".shortUrl").on('click', function () {
                Controller.api.short(this , false);
            });
            //推广二维码
            $(".tgqrcode").click(function(){
                Controller.api.short(this , true);
            });
            //模版切换
            $(".muban").click(function(){

                layer.open({
                    title: "模板切换",
                    type: 2,
                    content: "link/muban",
                    area: ['90%', '80%'],
                    maxmin: true
                });

            });

            $(".del-all").click(function(){
                var url =$.fn.bootstrapTable.defaults.extend.del_url+"/ids/137?del=all";
                layer.confirm('确定要全部删除？', {
                    btn: ['确定','取消'] //按钮
                }, function(){

                    $.ajax({
                        url:url,
                        type:'POST',
                        dataType:'json',
                        data:{'del':"all"},
                        success:function(res){
                            $('#myPublic1').modal('hide');

                            if(res.code == 0){
                                layer.msg(res.msg,{icon:1,time:1500,shade: 0.1},function(){
                                    $(".toolbar .btn-refresh").trigger('click');
                                });
                            }else{
                                layer.msg(res.msg,{icon:0,time:1500,shade: 0.1},function(){
                                    //window.location.reload();
                                });
                            }
                            // console.log(data);
                        }
                    });

                }, function(){
                });

            });

            function addoredit(url, name) {
                layer.open({
                        title: name,
                        type: 2,
                        content: url,
                        area: ['60%', '30%'],
                        maxmin: true
                    });
            }
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        auth: function () {
            Controller.api.bindevent();//这个地方如果不加，会造成你有跳转页面  不会出现延迟的那种消息通知
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },
            short: function (obj, is_ret , row) {
               console.log(obj , row);
                var url = push_url;
                var id = 0;
                if(row != undefined)
                {
                    id = row.id ||0;
                }

                $.ajax({
                    url:"short/shortUrl",
                    type:'POST',
                    dataType:'json',
                    data:{
                        url:url,
                        id:id
                    },
                    success:function(res){
                        $('#myPublic').modal('hide');


                        if(is_ret){
                            Controller.api.createCode(res.data);
                            return ;
                        }
                        if(res.code == 0){

                            layer.prompt({'value':res.data},function(val, index){

                                //layer.msg('得到了'+val);
                                layer.close(index);
                            });

                        }else{
                            layer.msg(res.msg,{icon:0,time:1500,shade: 0.1},function(){

                            });
                        }
                        // console.log(data);
                    },
                    error:function(){
                        layer.msg('系统500错误,请联系管理员');
                    }
                });

            },
            createCode:function(url){
                console.log(url);
                var qrimgcon = document.getElementById('qrimgcon');

                var erweicode = new QRCode(qrimgcon, {
                    width: 250,
                    height: 250
                });
                erweicode.clear();
                erweicode.makeCode(url);

                var canvas=document.getElementsByTagName('canvas')[0];
                var img = convertCanvasToImage(canvas);
                $('#qrimgcon').html(img);// 添加DOM
                //从 canvas 提取图片 image
                function convertCanvasToImage(canvas) {
                    //新建Image对象
                    var image = new Image();
                    // canvas.toDataURL 返回的是一串Base64编码的URL
                    image.src = canvas.toDataURL("image/png");
                    return image;
                }

                var erweishow = $('.qrshow,#qrimgcon');
                erweishow.fadeIn();
                $('.qrshow').click(function(){
                    erweishow.fadeOut();
                });
            },
            play:function(obj, is_ret , row){
                console.log(row);
                    layer.open({
                        title: '视频预览',
                        type: 2,
                        content: "link/play?video_url="+row.video_url,
                        area: ['60%', '60%'],
                        maxmin: true
                    });
            },
            setTop:function (obj , row){

            }
        }
    };

    return Controller;
});