define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'payset/index' + location.search,
                    add_url: 'payset/add',
                    edit_url: 'payset/edit',
                    del_url: 'payset/del',
                    multi_url: 'payset/multi',
                    table: 'pay_setting',
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
                        {field: 'id', title: __('Id'),visible:false},
                       /* {field: 'uid', title: __('Uid')},*/
                        {field: 'title', title: __('Title')},
                        {field: 'app_id', title: __('App_id'),visible:false},
                        {field: 'app_key', title: __('App_key'),visible:false},
                        {field: 'pay_channel', title: __('Pay_channel'),visible:false},
                        {field: 'model', title: __('Model'),visible:false},
                        {field: 'status', title: __('Status'), searchList: {"2":__('Status 2'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
            }
        }
    };
    return Controller;
});