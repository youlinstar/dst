	//打开字滑入效果
	window.onload = function() {
	    $(".connect p").eq(0).animate({
	        "left": "0%"
	    }, 600);
	    $(".connect p").eq(1).animate({
	        "left": "0%"
	    }, 400);
	};
	//jquery.validate表单验证
	$(document).ready(function() {
	    //登陆表单验证

		//56b0f9
	    $('#submit').click(function() {

	    	if($(".username").val() == '')
			{
				layer.msg('请输入用户名');
				return ;
			}

			if($(".password").val() == '')
			{
				layer.msg('请输入用户名');
				return ;
			}
	        var data = $('form').serializeArray();
	        $.post($('form').attr('action'), data, function(data, textStatus, xhr) {
	            layer.msg(data.msg, function(){
					if (data.code == 0) {
						setTimeout(function() {
							window.location.reload();
						}, 1000);
					}
					if(data.code == 1)
					{
						window.location.href = data.url;
					}
				});
	        }, 'json');
	    });

		$(document).keyup(function(event){
			if(event.keyCode ==13){
				$("#submit").trigger("click");
			}
		});


	    $.supersized({

	        // 功能
	        slide_interval: 4000, // 转换之间的长度
	        transition: 1, // 0 - 无，1 - 淡入淡出，2 - 滑动顶，3 - 滑动向右，4 - 滑底，5 - 滑块向左，6 - 旋转木马右键，7 - 左旋转木马
	        transition_speed: 1000, // 转型速度
	        performance: 1, // 0 - 正常，1 - 混合速度/质量，2 - 更优的图像质量，三优的转换速度//（仅适用于火狐/ IE浏览器，而不是Webkit的）

	        // 大小和位置
	        min_width: 0, // 最小允许宽度（以像素为单位）
	        min_height: 0, // 最小允许高度（以像素为单位）
	        vertical_center: 1, // 垂直居中背景
	        horizontal_center: 1, // 水平中心的背景
	        fit_always: 0, // 图像绝不会超过浏览器的宽度或高度（忽略分钟。尺寸）
	        fit_portrait: 1, // 纵向图像将不超过浏览器高度
	        fit_landscape: 0, // 景观的图像将不超过宽度的浏览器

	        // 组件
	        slide_links: 'blank', // 个别环节为每张幻灯片（选项：假的，'民'，'名'，'空'）
	        slides: [ // 幻灯片影像
				{
					image: bg
				},
				/*{
	                image: '/assets/img/1.jpg'
	            },
	            {
	                image: '/assets/img/2.jpg'
	            },
	            {
	                image: '/assets/img/3.jpg'
	            }*/
	        ]

	    });
	});