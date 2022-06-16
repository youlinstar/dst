define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {


    $('.aaa').on('input', function(){
        var _this = $(this).val();
        if(parseFloat(_this) > parseFloat(balances))
        {
            layer.msg("可提现金额为:"+balances+" 请重新输入!");
            $(this).val('');
            return;
        }
        console.log(balances < min_fee);
        if(parseFloat(balances) < parseFloat(min_fee))
        {
            layer.msg("最小提现金额为:"+min_fee);
            $(this).val('');
            return;
        }
        var poundage = poundages / 100;
        var shouxufei = _this * poundage;
        $("#shouxufei").html(shouxufei.toFixed(2)+"元");

        $("#account").val(_this - shouxufei.toFixed(2));
    });
    $(".aaa").blur(function(){

        if(parseFloat(this.value) < parseFloat(min_fee))
        {
            layer.msg("最小提现金额为:"+min_fee);
            $(this).val('');
            return;
        }
    });


    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'cash/index' + location.search,
                    add_url: 'cash/add',
                    edit_url: 'cash/edit',
                    del_url: 'cash/del',
                    multi_url: 'cash/multi',
                    table: 'cash_addvance',
                }
            });

            var table = $("#table");



            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                dblClickToEdit:false,
                onClickRow:function(row, $element, field)
                {
                    console.log(row,field);
                    if(field == "image")
                    {
                        layer.open({
                            type: 1,
                            title: "代理账号:【"+row.admin.username+"】打款金额: 【"+row.account+"】",
                            closeBtn: 0,
                            shadeClose: true,
                            skin: 'yourclass',
                            content: "<img width='340px' height='450px' src='"+row.image+"'>"
                        });
                    }
                },
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'admin.username',
                            title: __('Admin.username'),
                            formatter:function(row,item){
                                return row + "<br>余额<span style='color: red'>"+item.admin.balance+"</span>元";
                            }},
                       /* {field: 'uid', title: __('Uid')},
                        {field: 'pid', title: __('Pid')},
                        {field: 'blance', title: __('Blance')},*/
                        {field: 'status', title: __('Status'), searchList: {"1":__('Status 1'),"2":__('Status 2'),"3":__('Status 3'),"4":__('Status 4')}, formatter: Table.api.formatter.label},
                        {field: 'blance', title: __('Blance'),formatter:function(row , item){
                                if(row)
                                {
                                    return row + "元";
                                }
                                return "-";
                            }},
                        {field: 'fee', title: __('Fee'),formatter:function(row){
                            return row + "%";
                            }},
                        {
                            field: 'account',
                            title: __('Account'),
                            formatter:function(row){
                                if(row)
                                {
                                    return row + "元";
                                }
                                return "-";
                            }
                        },
                        {
                            field: 'image',
                            title: __('Image'),
                            formatter: Table.api.formatter.image
                        },
                        {field: 'remark', title: __('Remark')},
                        {field: 'type', title: __('Type'), searchList: {"0":__('Type 0'),"1":__('Type 1'),"2":__('Type 2')}, formatter: Table.api.formatter.label},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'edit_time', title: __('Edit_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},


                       /* {field: 'admin.nickname', title: __('Admin.nickname')},
                        {field: 'admin.password', title: __('Admin.password')},
                        {field: 'admin.salt', title: __('Admin.salt')},
                        {field: 'admin.avatar', title: __('Admin.avatar'), events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'admin.email', title: __('Admin.email')},
                        {field: 'admin.loginfailure', title: __('Admin.loginfailure')},
                        {field: 'admin.logintime', title: __('Admin.logintime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin.loginip', title: __('Admin.loginip')},
                        {field: 'admin.createtime', title: __('Admin.createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin.updatetime', title: __('Admin.updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'admin.token', title: __('Admin.token')},
                        {field: 'admin.view_id', title: __('Admin.view_id')},
                        {field: 'admin.balance', title: __('Admin.balance')},
                        {field: 'admin.min_fee', title: __('Admin.min_fee')},
                        {field: 'admin.poundage', title: __('Admin.poundage')},
                        {field: 'admin.pay_model', title: __('Admin.pay_model')},
                        {field: 'admin.pay_model1', title: __('Admin.pay_model1')},
                        {field: 'admin.date_fee', title: __('Admin.date_fee')},
                        {field: 'admin.month_fee', title: __('Admin.month_fee')},
                        {field: 'admin.kouliang', title: __('Admin.kouliang')},
                        {field: 'admin.ticheng', title: __('Admin.ticheng')},
                        {field: 'admin.status', title: __('Admin.status'), formatter: Table.api.formatter.status},*/
                        {
                            buttons: [
                                {
                                    name: 'labels',
                                    title:"不通过",
                                     text: "不通过",
                                   // icon: 'fa fa-youtube-play',
                                    classname: 'layui-btn layui-btn-sm layui-btn-warm btn-click ',
                                    extend:"data-toggle=\"tooltip\"",
                                    click:function(config , row){
                                        Controller.api.approval(this ,  row , 'tongguo');
                                    },
                                },
                                {
                                    name: 'label',
                                    title:"打款",
                                    text: "打款",
                                   // icon: 'fa fa-chain',
                                    classname: 'layui-btn layui-btn-sm layui-btn-info btn-click',
                                    extend:"data-toggle=\"tooltip\"",
                                    click:function(config , row){
                                        Controller.api.approval(this ,  row , 'dakuan');
                                    }
                                },


                            ],
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            formatter:function (value, row, index) {

                                var that = $.extend({}, this);
                                var table = $(that.table).clone(true);
                                console.log(table);
                                if(is_admins == 0)
                                {
                                    $(table).data("operate-labels", null);
                                    $(table).data("operate-label", null);
                                }
                                if(row.status == 4)
                                {
                                    $(table).data("operate-labels", null);
                                    $(table).data("operate-label", null);  //隐藏按钮操作 video为自定义按钮的name
                                }
                                that.table = table;
                                return Table.api.formatter.operate.call(that, value, row, index);
                            }
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
            approval:function (obj , item , flg) {
                console.log(obj , item, flg);
                var index = layer.load();
                $.ajax({
                    url:"cash/approval",
                    type:'get',
                    dataType:'json',
                    data:{
                        id:item.id,
                        flg:flg
                    },
                    success:function(res){


                        if(res.code == 1){

                            layer.msg(res.msg,{icon:0,time:1500,shade: 0.1},function(){
                                layer.close(index);
                            });

                        }else{
                            layer.msg(res.msg,{icon:0,time:1500,shade: 0.1},function(){
                                layer.close(index);
                            });
                        }
                        $(".btn-refresh").trigger('click');
                        // console.log(data);
                    },
                    error:function(){
                        layer.msg('系统500错误,请联系管理员');
                    }
                });

            }
        }
    };
    return Controller;
});