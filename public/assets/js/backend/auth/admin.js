define(['jquery', 'bootstrap', 'backend', 'table', 'form','layui'], function ($, undefined, Backend, Table, Form) {

    var slider = layui.slider;
    slider.render({
        elem: '#slideTest15',
        theme: '#1E9FFF', //主题色
        value:wocao,
        setTips:function(value){
            return value;
        },
        //range: true,
        change: function(value){

            $('#ticheng').val(value);
            var v = parseFloat(value) ;
            console.log(v);
            var shouxufei = 100 * (v / 100 );
            //var html = "（当前设置百分比："+value+"%,下级代理收入100你将抽成:"+shouxufei.toFixed(2)+"元）";
           // var html = "当前设置为:"+value+"% 一上级抽成"+admint+"%= 你的提成为"+v+"%, 【下级代理收入100你将抽成:"+shouxufei.toFixed(2)+"元】";
            
            var html = "当前设置为:"+value+"%  【下级代理订单收入100你将抽成:"+shouxufei.toFixed(2)+"元】";
            $("#caonima").html(html);
        }
    });

    var v = parseFloat(current);
    console.log(v);
    var shouxufei = 100 * (v / 100 );
    
    
    //var html = "（当前设置百分比："+value+"%,下级代理收入100你将抽成:"+shouxufei.toFixed(2)+"元）";
    //var html = "当前设置为"+current+"% 一上级抽成"+admint+"%= 你的提成为"+v+"%, 【下级代理收入100你将抽成:"+shouxufei.toFixed(2)+"元】";
    
     var html = "当前设置为:"+current+"%  【下级代理订单收入100你将抽成:"+shouxufei.toFixed(2)+"元】";

    $("#caonima").html(html);

    console.log(layer);
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'auth/admin/index',
                    add_url: 'auth/admin/add',
                    edit_url: 'auth/admin/edit',
                    del_url: 'auth/admin/del',
                    multi_url: 'auth/admin/multi',
                }
            });

            var table = $("#table");

            //在表格内容渲染完成后回调的事件
            table.on('post-body.bs.table', function (e, json) {
                $(".layui-table-body, .layui-table-box, .layui-table-cell").css('overflow','visible');
                $("tbody tr[data-index]", this).each(function () {
                    if (parseInt($("td:eq(1)", this).text()) == Config.admin.id) {
                        $("input[type=checkbox]", this).prop("disabled", true);
                    }
                });

                $('.caonima').on('change',function(){
                    console.log(this);
                    var user_id = $(this).attr('user_id');
                    var val = $(this).find("option:selected").val();
                    $.ajax({
                        type: "POST",
                        url: "/admin/auth/admin/edit/ids/"+user_id,
                        dataType: 'json',
                        data: {
                            row:{
                                "short":val,
                                "update":"1"
                            },
                        },
                        success:function(e)
                        {
                            if (e.code == 1) {

                                layer.msg(e.msg,{time:2000},function(){
                                });

                            } else {
                                layer.msg(e.msg);
                            }
                        }
                    });
                });
                $('.pay_set_wx').on('change',function(){
                    var user_id = $(this).attr('user_id');
                    var val = $(this).find("option:selected").val();
                    $.ajax({
                        type: "POST",
                        url: "/admin/auth/admin/edit/ids/"+user_id,
                        dataType: 'json',
                        data: {
                            row:{
                                "pay_model":val,
                                "update":"1"
                            },
                        },
                        success:function(e)
                        {
                            if (e.code == 1) {

                                layer.msg(e.msg,{time:2000},function(){
                                });

                            } else {
                                layer.msg(e.msg);
                            }
                        }
                    });
                });
                $('.pay_set_ali').on('change',function(){
                    var user_id = $(this).attr('user_id');
                    var val = $(this).find("option:selected").val();
                    $.ajax({
                        type: "POST",
                        url: "/admin/auth/admin/edit/ids/"+user_id,
                        dataType: 'json',
                        data: {
                            row:{
                                "pay_model1":val,
                                "update":"1"
                            },
                        },
                        success:function(e)
                        {
                            if (e.code == 1) {

                                layer.msg(e.msg,{time:2000},function(){
                                });

                            } else {
                                layer.msg(e.msg);
                            }
                        }
                    });
                });
            });

            var field = [];
            if(is_admin == 1)
            {
                field = [
                    {field: 'state', checkbox: true,},
                    {field: 'id', title: 'ID'},
                    {field: 'username', title:"代理账号"},
                    {field: 'pwd', title:"密码"},
                    /* {field: 'nickname', title: __('Nickname')},*/
                    {field: 'pid_name', title:"上级代理"},
                    {field: 'balance', title:"余额"},
                    {field: 'day_income', title:"今日收入"},
                    {field: 'yes_income', title:"昨日收入"},

                    {
                        field: 'groups_text',
                        title: __('Group'),
                        operate: false,
                        formatter: Table.api.formatter.label
                    },
                    {
                        field: 'short',
                        title:"短链接",
                        formatter:function(e , row){
                            var option = "<option value='0'>默认通道</option>";
                            $.each(short,function(index , obj){
                                if(index == 0)
                                {
                                        option += "<option value='"+obj.model+"'>"+obj.title+"</option>";
                                }
                                else
                                {
                                    if(e == obj.model)
                                    {
                                        option += "<option value='"+obj.model+"' selected>"+obj.title+"</option>";

                                    }
                                    else
                                    {
                                        option += "<option value='"+obj.model+"'>"+obj.title+"</option>";

                                    }
                                }
                            });
                            return "<select class='layui-form layui-select form-control caonima' user_id='"+row.id+"'>\n" +
                                option +
                                "        </select>\n";

                        }

                    },
                    {
                        field: 'pay_model',
                        title:"微信支付渠道",
                        formatter:function(val , row){
                            console.log(val);
                            var options = "<option value='0'>默认通道</option>";
                            $.each(pay_info,function(index , obj){
                                if(val == obj.id) {
                                    options += "<option value='"+obj.id+"' selected>"+obj.title+"</option>";

                                } else {
                                    options += "<option value='"+obj.id+"'>"+obj.title+"</option>";
                                }
                            });
                            return "<select class='layui-form layui-select form-control pay_set_wx' user_id='"+row.id+"'>\n" +
                                options +
                                "</select>\n";
                        }
                    },
                    {
                        field: 'pay_model1',
                        title:"支付宝支付渠道",
                        formatter:function(val , row){
                            var options = "<option value='0'>默认通道</option>";
                            $.each(pay_info,function(index , obj){
                                if(val == obj.id) {
                                    options += "<option value='"+obj.id+"' selected>"+obj.title+"</option>";
                                } else {
                                    options += "<option value='"+obj.id+"'>"+obj.title+"</option>";
                                }
                            });
                            return "<select class='layui-form layui-select form-control pay_set_ali' user_id='"+row.id+"'>\n" +
                                options +
                                "        </select>\n";
                        }
                    },
                    {field: 'status', title: __("Status"), formatter: Table.api.formatter.status},
                    {
                        field: 'logintime',
                        title: __('Login time'),
                        formatter: Table.api.formatter.datetime,
                        operate: 'RANGE',
                        addclass: 'datetimerange',
                        sortable: true
                    },
                    {
                        field: 'operate',
                        title: __('Operate'),
                        table: table,
                        events: Table.api.events.operate,
                        formatter: function (value, row, index) {
                            if (row.id == Config.admin.id) {
                                return '';
                            }
                            return Table.api.formatter.operate.call(this, value, row, index);
                        }
                    }
                ];
            }
            else {
                field = [
                    {field: 'state', checkbox: true,},
                    {field: 'id', title: 'ID'},
                    {field: 'username', title:"代理账号"},
                    //{field: 'pwd', title:"代理密码"},
                    /* {field: 'nickname', title: __('Nickname')},*/
                    {field: 'pid_name', title:"上级代理"},
                    {field: 'balance', title:"余额"},
                    {field: 'day_income', title:"今日收入"},
                    {field: 'yes_income', title:"昨日收入"},

                    {
                        field: 'groups_text',
                        title: __('Group'),
                        operate: false,
                        formatter: Table.api.formatter.label
                    },
                    {field: 'status', title: __("Status"), formatter: Table.api.formatter.status},
                    {
                        field: 'logintime',
                        title: __('Login time'),
                        formatter: Table.api.formatter.datetime,
                        operate: 'RANGE',
                        addclass: 'datetimerange',
                        sortable: true
                    },
                    {
                        field: 'operate',
                        title: __('Operate'),
                        table: table,
                        events: Table.api.events.operate,
                        formatter: function (value, row, index) {
                            if (row.id == Config.admin.id) {
                                return '';
                            }
                            return Table.api.formatter.operate.call(this, value, row, index);
                        }
                    }
                ];
            }

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                columns: [
                    field
                ]
            });

            $("#save").click(function () {

                username    = $('input[name="username"]').val();

                    passwd    = $('input[name="passwd"]').val();

                    kouliang   = $('input[name="kouliang"]').val();

                poundage   = $('input[name="poundage"]').val();

                ticheng   = $('input[name="ticheng"]').val();

                min_publish   = $('input[name="min_publish"]').val();

                //status   = $('input[name="status"]:checked').val();

                group   = $("#select_id").find("option:selected").val();

                min_fee = $("#min_fee").val();
                pay_model = $("#pay_model").val();


                var tokens = $('input[name="__token__"]').val();


                 param = {

                    username: username,
                     min_fee:min_fee,

                        passwd: passwd,

                    kouliang: kouliang,

                    // status: status,

                    poundage: poundage,

                    ticheng: ticheng,

                    min_publish: min_publish,

                    group:group,
                    __token__:null

                };

                 Form.api.submit($("#forms"));
                 //location.reload();


                /*$.ajax({

                    type: "POST",
                    url: "auth/admin/add",
                    dataType: 'json',
                    start: function (xhr) {
                        var token = xhr.getResponseHeader('__token__');
                        if (token) {
                            param.__token__ = token;
                            console.log(param);
                        }
                    },
                    data: param,

                    success: function (data) {

                        if (data.status == 1) {

                            layer.msg(data.msg,{time:2000},function(){

                                window.location.reload();

                            });

                        } else {

                            layer.msg(data.msg);

                        }

                    },

                    error: function (error) {

                        toastr.error(error);

                    }

                });*/

            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Form.api.bindevent($("form[role=form]"));
        },
        edit: function () {
            Form.api.bindevent($("form[role=form]"));
        }
    };
    return Controller;
});