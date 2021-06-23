<?php /*a:2:{s:56:"D:\www\sucai\application\admin\view\site_edit_cookie.php";i:1556029895;s:46:"D:\www\sucai\application\admin\view\layout.php";i:1555066292;}*/ ?>
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
	<div class="p-3"><form class="card" method="post" autocomplete="off" action="<?php echo url('admin/site/edit_cookie'); ?>">
    <input type="hidden" name="site_id" value="<?php echo htmlentities($website['site_id']); ?>">
    <?php if(!empty($cookie)): ?>
        <input type="hidden" name="cookie_id" value="<?php echo htmlentities($cookie['cookie_id']); ?>">
    <?php endif; ?>
    <div class="card-header">为 <?php echo htmlentities($website['title']); ?> 新增Cookie</div>
    <div class="card-body">
        <div class="form-group">
            <label>名称</label>
            <input type="text" name="name" class="form-control" value="<?php echo isset($cookie['name']) ? htmlentities($cookie['name']) : ''; ?>">
            <small class="form-text text-muted">该cookie的备注，可填写来源账号，方便自己记录</small>
        </div>
        <div class="form-group">
            <label>每日可用总次数</label>
            <input type="number" name="times" class="form-control" value="<?php echo isset($cookie['times']) ? htmlentities($cookie['times']) : 0; ?>">
            <small class="form-text text-muted">每日可用总次数，填写0为无限制，注意，如果每日使用次数超过总次数后将无法解析</small>
        </div>
        <div class="form-group">
            <label>Cookie详细内容</label>
            <textarea placeholder="Cookie内容详情" class="form-control" name="content"><?php echo isset($cookie['content']) ? htmlentities($cookie['content']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label>状态</label>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="status" value="1" <?php if(empty($cookie) || $cookie['status'] == 1): ?>checked<?php endif; ?>>
                <label class="custom-control-label">启用</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="status" value="0" <?php if(!empty($cookie) && $cookie['status'] == 0): ?>checked<?php endif; ?>>
                <label class="custom-control-label">关闭</label>
            </div>
            <small class="form-text text-muted">关闭的Cookie不会被用于解析资源</small>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-success btn-submit ajax-post">提交保存</button>
    </div>
</form>
</div>
</div>
<script type="text/javascript" src="static/js/common.js"></script>
</body>
</html>
