<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE');?>后台管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="generator" content="CoreThink">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="<?php echo C('WEB_SITE_TITLE');?>">
    <meta name="format-detection" content="telephone=no,email=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="apple-touch-icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/logo.png">
    <link rel="stylesheet" type="text/css" href="/Public/libs/lyui/dist/css/lyui.min.css">
    <link rel="stylesheet" type="text/css" href="/shop/Admin/View/Public/css/admin.css">
    
    <link rel="stylesheet" type="text/css" href="/Public/libs/lyui/dist/css/lyui.extend.min.css">
    <link rel="stylesheet" type="text/css" href="/shop/Admin/View/Public/css/style.css">
<style>
  .sum {overflow:hidden}
  .sum div{font-size: 20px; float: left; padding: 10px;color: #333;}
  </style>


    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/Public/libs/jquery/1.x/jquery.min.js"></script>
     <link rel="stylesheet" href="/Public/plugin/themes/default/default.css" />
    <script charset="utf-8" src="/Public/plugin/kindeditor-min.js"></script>
    <script charset="utf-8" src="/Public/plugin/lang/zh_CN.js"></script>

    <!-- 日期 -->
    <script type="text/javascript" src="/Public/libs/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/Public/libs/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <!-- 日期js cs -->
    <link href="/Public/libs/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
    <link href="/Public/libs/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">

</head>
<!-- <body class="admin_index_index"> -->
<body class="admin_config_group" >
    <div class="clearfix full-header">
        
                <!-- 顶部导航 -->
                <div class="navbar navbar-default navbar-fixed-top main-nav" role="navigation">
                    <div class="container-fluid">
                        <div>
                            <div class="navbar-header navbar-header-inverse">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse-top">
                                    <span class="sr-only">切换导航</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" target="_blank" href="/">
                                    <span><b><span style="color: #2699ed;">后台管理</span></b></span>
                                </a>
                            </div>
                            <div class="collapse navbar-collapse navbar-collapse-top">
                                <ul class="nav navbar-nav">
                                    <!-- 主导航 -->
                                    <li <?php if (CONTROLLER_NAME=='Index') { echo "class='active'"; } ?> ><a href="<?php echo U('Admin/Index/index');?>"><i class="fa fa-home"></i> 首页</a></li>
                                    <?php if(is_array($_menu_list_g)): foreach($_menu_list_g as $key=>$g_val): ?><li <?php if ($_menu_tab['gid']==$g_val['id'] && CONTROLLER_NAME!='Index') { echo "class='active'"; } ?> >
                                    <a href="<?php if($g_val['col'] && $g_val['act']) echo U('Admin/'.$g_val['col'].'/'.$g_val['act']); ?>" target="">
                                        <i class="fa <?php echo ($g_val['icon']); ?>"></i>
                                        <span><?php echo ($g_val["name"]); ?></span>
                                    </a>
                                    </li><?php endforeach; endif; ?>                                                  
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="<?php echo U('Admin/Index/removeRuntime');?>" style="border: 0;text-align: left" class="btn ajax-get no-refresh"><i class="fa fa-trash"></i> 清空缓存</a></li>
                                    <li><a target="_blank" href="/"><i class="fa fa-external-link"></i> 打开前台</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-user"></i> <?php echo ($_user_auth["username"]); ?> <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a target="_blank" href="/"><i class="fa fa-external-link"></i> 打开前台</a></li>
                                            <li><a href="<?php echo U('Admin/Index/removeRuntime');?>" style="border: 0;text-align: left;" class="btn text-left ajax-get no-refresh"><i class="fa fa-trash"></i> 清空缓存</a></li>
                                            <li><a href="<?php echo U('Admin/Pubss/logout');?>" class="ajax-get"><i class="fa fa-sign-out"></i> 退出</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        
    </div>

    <div class="clearfix full-container" id="full-container">
        
            <input type="hidden" name="check_version_url" value="<?php echo U('Admin/Update/checkVersion');?>">
            <div class="container-fluid with-top-navbar" style="height: 100%;overflow: hidden;">
                <div class="row" style="height: 100%;">
                    <!-- 后台左侧导航 S-->
                    <div id="sidebar" class="col-xs-12 col-sm-3 sidebar tab-content">
                        <!-- 模块菜单 -->
                        <nav class="navside navside-default" role="navigation">
                            <?php if($_menu_list_p): ?>
                                <ul class="nav navside-nav navside-first">
                                    <?php if(is_array($_menu_list_p)): $fkey = 0; $__LIST__ = $_menu_list_p;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_ns_first): $mod = ($fkey % 2 );++$fkey;?><li>
                                            <a data-toggle="collapse" href="#navside-collapse-<?php echo ($_ns_first["id"]); ?>-<?php echo ($fkey); ?>">
                                                <i class="<?php echo ($_ns_first["icon"]); ?>"></i>
                                                <span class="nav-label"><?php echo ($_ns_first["name"]); ?></span>
                                                <span class="angle fa fa-angle-down"></span>
                                                <span class="angle-collapse fa fa-angle-left"></span>
                                            </a>
                                            <?php if(!empty($_menu_list_c)): ?><ul class="nav navside-nav navside-second collapse in" id="navside-collapse-<?php echo ($_ns_first["id"]); ?>-<?php echo ($fkey); ?>">
                                                    <?php if(is_array($_menu_list_c)): $skey = 0; $__LIST__ = $_menu_list_c;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_ns_second): $mod = ($skey % 2 );++$skey; if(($_ns_first['id']) == $_ns_second['pid']): ?><li <?php  if(!empty($_select_url) && strtolower($_ns_second['col'].'-'.$_ns_second['act'])== $_select_url) echo 'class="active"'; elseif(empty($_select_url) && $_ns_second['col'] == CONTROLLER_NAME) echo 'class="active"'; ?>>
                                                            <a href="<?php echo U($_ns_second['col'].'/'.$_ns_second['act']); ?>" >
                                                                <i class="<?php echo ($_ns_second["icon"]); ?>"></i>
                                                                <span class="nav-label"><?php echo ($_ns_second["name"]); ?></span>
                                                            </a>
                                                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                </ul><?php endif; ?>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                            <?php endif; ?>
                        </nav>
                    </div>
                    <!-- 后台左侧导航 E-->

                    <!-- 右侧内容 S-->
                    
   <div id="main" class="col-xs-12 col-sm-9 main" style="overflow-y: scroll;">
        <!-- 面包屑导航 -->
        <ul class="breadcrumb">
            <li><i class="fa fa-map-marker"></i></li>
            <?php if(is_array($_menu_tab['name'])): foreach($_menu_tab['name'] as $key=>$tab_v): ?><li class="text-muted"><?php echo ($tab_v); ?></li><?php endforeach; endif; ?>
        </ul>

        <!-- 主体内容区域 -->
        <div class="tab-content ct-tab-content">
            <div class="panel-body">
                <div class="builder formbuilder-box">
                        <div class="form-group"></div>
                        <!-- 顶部工具栏按钮 -->
                        <div class="builder-toolbar">
                            <div class="row">
                                <!-- 工具栏按钮 -->
                                    <!-- <div class="col-xs-12 col-sm-8 button-list clearfix">
                                        <div class="form-group">
                                            <a title="新增" class="btn btn-primary-outline btn-pill" href="<?php echo U('Scroll/add');?>">新增</a>&nbsp;
                                        </div>
                                    </div> -->

                                <!-- 搜索框 -->
                                <div class="col-xs-12 col-sm-12 clearfix">
                                    <form class="form" method="post" action="">
                                        <div class="form-group right">
                                            <div style="float:left;width:150px;margin-right:20px" class="">
                                                <input type="text" name="date_start" class="search-input form-control date" value="<?php echo ($_GET["date_start"]); ?>" placeholder="开始日期">
                                            </div>
                                            <div style="float:left;width:150px;margin-right:20px" class="">
                                                <input type="text" name="date_end" class="search-input form-control date" value="<?php echo ($_GET["date_end"]); ?>" placeholder="结束日期">
                                            </div>
                                            <div style="float:left;width:120px;margin-right:20px" class="">
                                                <select name="querytype" class="form-control lyui-select select">
                                                    <option  value="0" selected>请选择类型</option>
                                                    <option  value="1">等待审核</option>
                                                    <option  value="2">审核通过</option>
                                                    <option  value="3">审核未通过</option>
                                                    <option  value="4">交易完成</option>
                                                    <option  value="5">买家待确认</option>
                                                    <option  value="6">等待打款</option>
                                                    <option  value="7">等待收款</option>
                                                    <option  value="8">转让方申诉</option>
                                                    <option  value="9">收藏方申诉</option>
                                                    <option  value="10">预约</option>
                                                </select>
                                            </div>
                                            <div style="width:250px" class="input-group search-form">
                                                <input  type="text" name="keyword" class="search-input form-control"  placeholder="UID">
                                                <span class="input-group-btn"><a class="btn btn-default search-btn"><i class="fa fa-search"></i></a></span>
                                            </div>
                                            <div class="sum">
                                                <div>待审核:<?php echo ($status1); ?></div>
                                                <div>转入方待确认:<?php echo ($status2); ?></div>
                                                <div>交易完成:<?php echo ($status3); ?></div>
                                                <div>正在交易:<?php echo ($status4); ?></div>
                                                <div>待解冻:<?php echo ($status5); ?></div>
                                                <div>已解冻:<?php echo ($status6); ?></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <style type="text/css">
                            tr,td{
                               margin: 0 !important;
                               padding: 5px 5px !important;
                            }
                        </style>

                        <!-- 数据列表 -->
                        <div class="builder-container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="builder-table">
                                        <div class="panel panel-default table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                              <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>出售用户</th>
                                                    <th>购买用户</th>
                                                    <th>金额</th>
                                                    <th>状态</th>
                                                    <th>生成时间</th>
                                                    <th>结束时间</th>
													<th>解冻时间</th>
                                                    <!-- <th>类型</th> -->
                                                    <th style="max-width:20%" >操作</th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                                                        
                                                            <td><?php echo ($data['record_id']); ?></td>
                                                            <td>
                                                                <?php echo ($data['out_uid']); ?>
                                                            </td>
                                                            <!-- 财富 -->
                                                            <td>
                                                                <?php if($data['in_uid'] != 0): echo ($data['in_uid']); ?>
                                                                <?php else: ?>
                                                                    等待购买<?php endif; ?>
                                                            </td>
                                                            
                                                            <td><?php echo ($data['record_price']); ?></td>
                                                            <td>
                                                            <?php if($data['record_status'] == 1): ?>等待审核
                                                            <?php elseif($data['record_status'] == 2): ?>
                                                                    审核通过
                                                            <?php elseif($data['record_status'] == 3): ?>
                                                                    审核未通过
                                                            <?php elseif($data['record_status'] == 3): ?>
                                                                    审核未通过
                                                            <?php elseif($data['record_status'] == 4): ?>
                                                                    交易完成
                                                            <?php elseif($data['record_status'] == 5): ?>
                                                                    买家待确认
                                                            <?php elseif($data['record_status'] == 6): ?>
                                                                    等待打款
                                                            <?php elseif($data['record_status'] == 7): ?>
                                                                    等待收款
                                                            <?php elseif($data['record_status'] == 8): ?>
                                                                    转让方申诉
                                                            <?php elseif($data['record_status'] == 9): ?>
                                                                    收藏方申诉
                                                            <?php elseif($data['record_status'] == 10): ?>
                                                                    预约<?php endif; ?>
                                                            </td>
                                                            <td><?php echo (date("Y-m-d H:i:s",$data[generate_time])); ?></td>
                                                            <td>
                                                                <?php echo (date("Y-m-d H:i:s",$data['complete_time'])); ?>
                                                            </td>
															<td>
																<?php if($data["dj_time"] != ''): echo (date("Y-m-d H:i:s",$data['dj_time'])); endif; ?>
															</td>
                                                            
                                                            <!-- <td> -->
                                                                    <!-- <?php if($data['is_yuyue_s'] == 1): ?>-->
                                                                        <!-- 预约 -->
                                                                    <!-- <?php elseif($data['is_yuyue_s'] == 0): ?> -->
                                                                        <!-- 收藏 -->
                                                    
                                                                    <!--<?php endif; ?> -->
                                                            <!-- </td> -->

                                                            <td>
																<?php if($data['record_status'] == 4 && $data['dj_time'] > time()): ?><a name="forbid" title="解冻" class="label label-success-outline label-pill ajax-get confirm" href="javascript:" onclick="thaw('<?php echo ($data[record_id]); ?>')">解冻</a><?php endif; ?>
                                                                <?php if($data['record_status'] == 2): ?><a name="forbid" title="取消" class="label label-success-outline label-pill ajax-get confirm" href="javascript:" onclick="quxiao('<?php echo ($data[record_id]); ?>')">取消</a><?php endif; ?>
                                                                <?php if($data['record_status'] == 1): ?><a name="forbid" title="通过" class="label label-success-outline label-pill ajax-get confirm" href="javascript:" onclick="up_record_status('<?php echo ($data[record_id]); ?>',2)">通过</a>
                                                                    <a name="forbid" title="不通过" class="label label-danger-outline label-pill ajax-get confirm" href="javascript:" onclick="up_record_status('<?php echo ($data[record_id]); ?>',3)">不通过</a>
                                                                <?php elseif($data['record_status'] == 8 OR $data['record_status'] == 9): ?>
                                                                    <a name="forbid" title="订单重置" class="label label-success-outline label-pill ajax-get" href="javascript:" onclick="updateorder('<?php echo ($data[record_id]); ?>',3)">订单重置</a><?php endif; ?>
                                                            </td>
                                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                                    <?php if(empty($list)): ?><tr class="builder-data-empty">
                                                            <td class="text-center empty-info" colspan="20">
                                                                <i class="fa fa-database"></i> 暂时没有数据<br>
                                                            </td>
                                                        </tr><?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <?php if(!empty($show)): ?><ul class="pagination"><?php echo ($show); ?></ul><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
    </div>                   
</div>

                    <!-- 右侧内容 E-->
                    
                </div>


            </div>
        

    </div>

    <div class="clearfix full-footer">
        
    </div>

    <div class="clearfix full-script">
        <div class="container-fluid">
            <input type="hidden" id="corethink_home_img" value="__HOME_IMG__">
            <script type="text/javascript" src="/Public/libs/lyui/dist/js/lyui.min.js"></script>
            <script type="text/javascript" src="/shop/Admin/View/Public/js/admin.js"></script>
            
     <script type="text/javascript">
        function up_record_status(id,type){
            $.get("<?php echo U('User/up_record_status');?>",{id:id,type:type}, function(res){
                if(res.status==1){
                    alert(res.info);
                    location.reload();
                }else{
                    alert(res.info)
                }
              });
        }
		function thaw(id){
			if(confirm('是否解冻？')){
				$.get("<?php echo U('User/thaw');?>",{id:id}, function(res){
					if(res.status==1){
						alert(res.info);
						location.reload();
					}else{
						alert(res.info)
					}
				});
			}
		}

        function quxiao(id){
            if(confirm('是否取消？')){
                $.get("<?php echo U('User/quxiao');?>",{id:id}, function(res){
                    if(res.status==1){
                        alert(res.info);
                        location.reload();
                    }else{
                        alert(res.info)
                    }
                });
            }
        }
		
        function updateorder(id){
            if(confirm('是否重置？')){
                $.get("<?php echo U('User/chongzhi');?>",{id:id}, function(res){
                if(res.status==1){
                    alert(res.info);
                    location.reload();
                }else{
                    alert(res.info)
                }
              });
            }
                
         }   
        $('.date').datetimepicker({
            format: 'yyyy-mm-dd',
            language:"zh-CN",
            minView:2,
            autoclose:true,
            todayBtn:1, //是否显示今日按钮
        });
 


    $(document).ready(function(){
  
     $(".bky").click(function(){
      
        this.href="###";
        alert("您无权限访问");  
        return false;     

        });

    });
</script>
    <script type="text/javascript" src="/Public/libs/lyui/dist/js/lyui.extend.min.js"></script>

        </div>
    </div>
</body>
</html>