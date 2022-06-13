define(['jquery', 'bootstrap', 'backend', 'table', 'form','bootstrap-table-fixed-columns'], function ($, undefined, Backend, Table, Form , columnFixedType) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'hezi/index' + location.search,
                    add_url: 'hezi/add',
                    edit_url: 'hezi/edit',
                    del_url: 'hezi/del',
                    multi_url: 'hezi/multi',
                    table: 'hezi',
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
                        {field: 'title', title: __('Title')},
                       /* {field: 'uid', title: __('Uid')},*/
                        {
                            field: 'video',
                            title: __('Video'),
                            formatter:Table.api.formatter.url
                        },
                        {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.label},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {
                            field: 'operate',
                            buttons: [
                                {
                                    name: 'label',
                                    title:"盒子推广链接",
                                    // text: "播放",
                                    icon: 'fa fa-chain',
                                    classname: 'btn btn-xs btn-primary btn-click',
                                    extend:"data-toggle=\"tooltip\"",
                                    click:function(config , row){
                                        Controller.api.short(this , false ,  row);
                                    },
                                }

                            ],
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
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
            },
            short: function (obj, is_ret , row) {
                console.log(obj , row);
                var url = push_url+"&hezi="+row.id;
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
                            Controller.api.createCode(res.data)
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
        }
    };
    return Controller;
});