define(['jquery', 'bootstrap', 'backend', 'table', 'form' ], function ($, undefined, Backend, Table, Form) {

    var layer = layui.layer;
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'stock/index' + location.search,
                    add_url: 'stock/add',
                    edit_url: 'stock/edit',
                    del_url: 'stock/del',
                    multi_url: 'stock/multi',
                    table: 'stock',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                      /*  {field: 'cid', title: __('Cid')},
                        {field: 'uid', title: __('Uid')},*/
                        {
                            field: 'is_push',
                            title: __('is_push'),
                            formatter:function (value , row) {
                                if(value == 1)
                                {
                                    return "<a href=\"javascript:;\" class=\"btn btn-xs btn-small btn-success \" title=\"已推广\"> 已推广</a>";
                                }
                                return "<a href=\"javascript:;\" class=\"btn btn-xs btn-small btn-danger \" title=\"未推广\"> 未推广</a>";

                            }
                        },
                        {field: 'title', title: __('Title')},
                      /*  {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},*/
                        {
                            field: 'img',
                            title: __('Url'),
                            formatter: Table.api.formatter.image,
                            events: Table.api.events.image,
                            operate: false,

                        },

                        {field: 'category.name', title: __('Category.name')},

                        {field: 'input_time', title: __('Input_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                       /* {field: 'sort', title: __('Sort')},*/
/*
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
*/
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });


            $(".btn-push").click(function(){

                console.log(layer);
                var ids = Table.api.selectedids(table);
               if(ids.length == 0)
               {
                   layer.msg("请选择视频",{icon:0,time:1500,shade: 0.1});
                   return;
               }

                $('#myPublic').modal('show');
                $('.batch-add-post').off('click').on('click',function(){
                    var ds_money = $('input[name="ds_money"]').val();
                    var effect_time = $('input[name="effect_time"]').val();

                    var param = {
                        batch:ids
                        ,money:ds_money
                        ,effect_time:effect_time
                    };

                    $.ajax({
                        url:"stock/push",
                        type:'POST',
                        dataType:'json',
                        data:param,
                        success:function(res){
                            $('#myPublic').modal('hide');

                            if(res.code == 0){
                                layer.msg(res.msg,{icon:1,time:1500,shade: 0.1},function(){
                                    $(".toolbar .btn-refresh").trigger('click');
                                });
                            }else{
                                layer.msg(res.msg,{icon:0,time:1500,shade: 0.1},function(){
                                   // window.location.reload();
                                });
                            }
                            // console.log(data);
                        }
                    });
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

            $(".getCheckData1").click(function(){
                var ids = Table.api.selectedids(table);
                var all = $(this).attr('data-all');
                if(ids.length == 0 && !all)
                {
                    layer.msg("请选择视频",{icon:0,time:1500,shade: 0.1});
                    return;
                }
                $('#myPublic1').modal('show');
                $('.batch-add-post1').off('click').on('click',function(){
                    var ds_money = $('input[name="ds_money2"]').val();
                    var ds_money1 = $('input[name="ds_money1"]').val();
                    var effect_time = $('input[name="effect_time"]').val();

                    var param = {
                        batch:ids,
                        money:ds_money,
                        money1:ds_money1,
                        effect_time:effect_time
                    };
                    if(all){
                        param['all'] = true;
                    }

                    // console.log(money);return ;
                    $.ajax({
                        url:"stock/push1",
                        type:'POST',
                        dataType:'json',
                        data:param,
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
                });

            });

            //批量添加资源
            $('.add_btn_piliang').on('click',function(){

                layer.open({
                    title: "批量添加资源",
                    type: 2,
                    content: "stock/add_piliang",
                    area: ['60%', '70%'],
                    maxmin: true
                });
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));



            }
        }

    };


    return Controller;
});