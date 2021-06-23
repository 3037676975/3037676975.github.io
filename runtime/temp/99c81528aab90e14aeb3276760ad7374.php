<?php /*a:2:{s:50:"D:\www\sucai\application\admin\view\site_index.php";i:1556027495;s:46:"D:\www\sucai\application\admin\view\layout.php";i:1555066292;}*/ ?>
<!DOCTYPE html>
<html style="background: #f2f2f2;">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>管理中心</title>
	<base href="<?php echo htmlentities($_G['site_url']); ?>">
	<script src="static/js/jquery-3.3.1.min.js"></script>
	<script src="static/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="static/css/common.css">
</head>
<body>
<nav class="d-flex justify-content-between fixed-top admin-top bg-white">
	<div class="d-flex justify-content-start pl-3">
		<a class="px-3" href="<?php echo htmlentities($_G['site_url']); ?>" target="_blank">前台首页</a>
	</div>
	<div class="d-flex justify-content-end pr-3">
		<a class="px-3" href="javascript:;">欢迎您，<?php echo htmlentities($_G['member']['username']); ?></a>
		<a class="px-3" href="<?php echo url('admin/account/logout'); ?>">退出</a>
	</div>
</nav>
<div class="left-bar">
	<h5>管理中心</h5>
	<div class="left-nav">
		<a class="<?php if(app('request')->controller() == 'Index'): ?>active<?php endif; ?>" href="<?php echo url('admin/index/index'); ?>">控 制 台</a>
		<a class="<?php if(app('request')->controller() == 'Setting'): ?>active<?php endif; ?>" href="<?php echo url('admin/setting/index'); ?>">系统设置</a>
		<a class="<?php if(app('request')->controller() == 'Site'): ?>active<?php endif; ?>" href="<?php echo url('admin/site/index'); ?>">站点配置</a>
		<a class="<?php if(app('request')->controller() == 'User'): ?>active<?php endif; ?>" href="<?php echo url('admin/user/index'); ?>">会员数据</a>
		<a class="<?php if(app('request')->controller() == 'Data'): ?>active<?php endif; ?>" href="<?php echo url('admin/data/index'); ?>">附件管理</a>
		<a class="<?php if(app('request')->controller() == 'Log'): ?>active<?php endif; ?>" href="<?php echo url('admin/log/index'); ?>">解析记录</a>
		<a class="<?php if(app('request')->controller() == 'Card'): ?>active<?php endif; ?>" href="<?php echo url('admin/card/index'); ?>">充值卡密</a>
		<a class="<?php if(app('request')->controller() == 'Queue'): ?>active<?php endif; ?>" href="<?php echo url('admin/queue/index'); ?>">计划任务</a>
		<a class="<?php if(app('request')->controller() == 'Tools'): ?>active<?php endif; ?>" href="<?php echo url('admin/tools/index'); ?>">更新缓存</a>
	</div>
</div>
<div class="admin-content">
	<div class="p-3"><div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="">
            <a class="btn btn-primary btn-sm" href="<?php echo url('admin/site/edit'); ?>">新增站点</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover table-card mb-0">
            <thead>
                <tr>
                    <th scope="col">网站名称</th>
                    <th scope="col">官网地址</th>
                    <th scope="col">URL特征</th>
                    <th scope="col">状态</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($site_list) || $site_list instanceof \think\Collection || $site_list instanceof \think\Paginator): $i = 0; $__LIST__ = $site_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo htmlentities($site['title']); ?></td>
                        <td><?php echo htmlentities($site['url']); ?></td>
                        <td><?php echo htmlentities($site['url_regular']); ?></td>
                        <td><?php echo htmlentities($site['status_text']); ?></td>
                        <td>
                            <a href="<?php echo url('admin/site/cookie',['site_id'=>$site['site_id']]); ?>">Cookie</a>
                            <a href="<?php echo url('admin/site/edit',['site_id'=>$site['site_id']]); ?>">编辑</a>
                            <a class="ajax-link" data-mode="confirm" href="<?php echo url('admin/site/delete',['site_id'=>$site['site_id']]); ?>">删除</a>
                        </td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($page): ?>
        <div class="card-footer"><?php echo $page; ?></div>
    <?php endif; ?>
</div>
</div>
</div>
<script type="text/javascript" src="static/js/common.js"></script>
</body>
</html>
