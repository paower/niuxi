<?php
return array(
	//'配置项'=>'配置值'
	'VIEW_PATH'		=> './Tpl/', //模板位置单独定义	
	'DEFAULT_THEME' => 'wap',     //定义模板主题
	'THEME_LIST' => 'wap', 
	'TMPL_PARSE_STRING'    => array(
		//手机端静态文件
        '__WCSS__'       => __ROOT__ . '/Public/home/wap/css',
        '__WJS__'        => __ROOT__ . '/Public/home/wap/js',
        '__WIMG__'       => __ROOT__ . '/Public/home/wap/images',
        '__WAP__'        => __ROOT__ . '/Public/home/wap',
		'__KLINE__'      => __ROOT__ . '/Public/home/wap/kline',

        '__COM__'        => __ROOT__ . '/Public/home/common',
        '__MUSIC__'		 => __ROOT__ . '/Public/music',

        //上传头像
        '__IMGHEAD__'        => __ROOT__ . '/Public/home/wap/heads',
        //头像上传JD
        '__IMGJS__'        => __ROOT__ . '/Public/home/wap/jsa',

        '__LAYERUI__'       => __ROOT__ . '/Public/home/wap/layui',
		
		'__UPLOADS__'       =>__ROOT__ . '/Uploads',

    ),
    'appkey' => '15448_958ce41f458e16d927a872adb3246259',
    'secret_key' => '3b57467a49cad9a453cc9d3c5a0c8037',
    'return_url' => 'http://'.$_SERVER['HTTP_HOST'].'/Login/pay_return_url',
    'notify_url' => 'http://'.$_SERVER['HTTP_HOST'].'/Login/pay_notify_url',
);