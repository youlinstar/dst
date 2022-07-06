define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index' + location.search,
                    add_url: 'order/add',
                    edit_url: 'order/edit',
                    del_url: 'order/del',
                    multi_url: 'order/multi',
                    table: 'pay_order',
                }
            });

            var table = $("#table");

            if(is_admin)
            {
                var field = [
                    {checkbox: true},
                    {field: 'id', title: __('Id')},
                    {
                        field: 'uid',
                        title: __('Uid'),
                        formatter:function(val){
                            if(val == 0)
                            {
                                return "-";
                            }
                            return user_Info[val] + "【ID"+val+"】";
                        }
                    },
                    {
                        field: 'pid',
                        title: __('pid'),
                        formatter:function(val){
                            if(val == 0)
                            {
                                return "-";
                            }
                            return user_Info[val] + "【ID"+val+"】";
                        }
                    },
                    {field: 'transact', title: __('Transact')},
                    {field: 'pay_channel', title:"支付渠道",searchList:Controller.api.searchListOption(),
                        formatter:function (value,row,index) {
                            let custom={};
                            $.each(pay_channelValue,function(index , obj){
                                custom[obj.model]="black";
                            });
                            this.custom=custom;
                            return Table.api.formatter.normal.call(this, value, row, index);
                        }
                    },
                    {field: 'status', title: __('Status'), searchList: {"1":"支付成功","2":"未支付"},
                        formatter:function (value,row,index) {
                            this.custom={"1": "success","2": "danger"};
                            return Table.api.formatter.normal.call(this, value, row, index);
                        }
                    },
                    {
                        field: 'is_kouliang',
                        title:"扣量",
                        invisible:false,
                        searchList: {"1":"未扣量","2":"扣量"},
                        formatter:function (value,row,index) {
                            this.custom={"1": "success","2": "danger"};
                            return Table.api.formatter.normal.call(this, value, row, index);
                        }
                    },
                    {
                        field: 'price',
                        title: __('Price'),
                        visible:true,
                        formatter:function(row,item)
                        {
                            if(item.price == 0)
                            {
                                return "-";
                            }

                            return parseFloat(item.price) - parseFloat(item.tc_money);
                        }
                    },
                    {
                        field: 'is_month',
                        title: __('Is_month'),
                        searchList: {"1":__('Is_month 1'),"2":__('Is_month 2')},
                        visible:false,
                        formatter: Table.api.formatter.normal,
                    },
                    {
                        field: 'is_date',
                        title: __('Is_date'),
                        searchList: {"1":__('Is_date 1'),"2":__('Is_date 2')},
                        visible:false,
                        formatter: Table.api.formatter.normal
                    },
                    {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                    //{field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                    {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                ];
            }
            else
            {
                var field = [
                    {checkbox: true},
                    {field: 'id', title: __('Id')},
                    {field: 'id', title: __('Id')},
                    {
                        field: 'uid',
                        title: __('Uid'),
                        formatter:function(val){
                            if(val == 0)
                            {
                                return "-";
                            }
                            return user_Info[val] + "【ID"+val+"】";
                        }
                    },
                    {
                        field: 'pid',
                        title: __('pid'),
                        formatter:function(val){
                            if(val == 0)
                            {
                                return "-";
                            }
                            return user_Info[val] + "【ID"+val+"】";
                        }
                    },
                    {field: 'transact', title: __('Transact')},
                    {field: 'pay_channel', title:"支付渠道",searchList:Controller.api.searchListOption(),
                        formatter:function (value,row,index) {
                            let custom={};
                            $.each(pay_channelValue,function(index , obj){
                                custom[obj.model]="black";
                            });
                            this.custom=custom;
                            return Table.api.formatter.normal.call(this, value, row, index);
                        }
                    },
                    {field: 'status', title: __('Status'), searchList: {"1":"支付成功","2":"未支付"},
                        formatter:function (value,row,index) {
                            this.custom={"1": "success","2": "danger"};
                            return Table.api.formatter.normal.call(this, value, row, index);
                        }
                    },
                    {
                        field: 'price',
                        title: __('Price'),
                        visible:true,
                        formatter:function(row,item)
                        {
                            if(item.price == 0)
                            {
                                return "-";
                            }

                            return parseFloat(item.price) - parseFloat(item.tc_money);
                        }
                    },
                    /* {field: 'tc_money', title: __('Tc_money')},*/
                    /*{field: 'pid', title: __('Pid')},
                    {field: 'pid_top', title: __('Pid_top')},*/
                    //{field: 'is_kouliang', title: __('Is_kouliang'), searchList: {"1":__('Is_kouliang 1'),"2":__('Is_kouliang 2')}, formatter: Table.api.formatter.normal},
                    {
                        field: 'is_month',
                        title: __('Is_month'),
                        searchList: {"1":__('Is_month 1'),"2":__('Is_month 2')},
                        visible:false,
                        formatter: Table.api.formatter.normal,
                    },
                    {
                        field: 'is_date',
                        visible:false, // false 隐藏 true 显示
                        title: __('Is_date'),
                        searchList: {"1":__('Is_date 1'),"2":__('Is_date 2')},
                        formatter: Table.api.formatter.normal
                    },
                    {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                    //{field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                    {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                ];
            }
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                onLoadSuccess:function(data){
                    if(is_admin == 0)
                    {
                        table.bootstrapTable("hideColumn","is_kouliang");
                    }
                },
                hideColumn:['id'],
                columns: [
                    field
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
            searchListOption:function () {
                let searchListOption={};
                let searchListArrayTmp=[];
                $.each(pay_channelValue,function(index , obj){
                    let listTmp={};
                    listTmp[obj.model]=obj.title;
                    searchListArrayTmp[index]=listTmp;
                });
                for (let c in searchListArrayTmp) {
                    let key = Object.keys(searchListArrayTmp[c])[0];
                    searchListOption[key] = searchListArrayTmp[c][key];
                }
                console.log(searchListOption);
                return searchListOption;
            }
        }
    };
    return Controller;
});