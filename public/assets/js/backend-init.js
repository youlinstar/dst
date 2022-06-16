define(['backend'], function (Backend) {
    require.config({
        paths: {
            'layui': '../libs/layui/layui.all',
        },
        shim: {
            'layui':{
                deps:['css!../libs/layui/css/layui.css'],
                exports: "layui"
            },
        }
    });
});