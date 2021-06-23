<?php /*a:2:{s:58:"D:\www\sucai\application\admin\view\common_showmessage.php";i:1554964083;s:46:"D:\www\sucai\application\admin\view\layout.php";i:1555066292;}*/ ?>
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
	<div class="p-3"><?php
switch ($code) {
    case -1:
        $show_class = 'error';
        break;
    case 2:
        $show_class = 'loading';
        break;
    case 1:
        $show_class = 'right';
        break;
    default:
        $show_class = 'info';
}
?>
<style type="text/css">
/*Jump*/
.system-jump-box {
    border: 0.25rem solid #c6e9ff;
    margin: 1rem 0;
}

.system-jump-message>h5>.system-jump-icon {
    font-size: 1.25rem;
    width: 1.25rem;
    height: 1.25rem;
    margin-right: 0.75rem;
}

.system-jump-right {
    background: #e2ffea;
}

.system-jump-right>h5 {
    color: #59ba74;
}

.system-jump-info {
    background: #F2F9FD;
}

.system-jump-info>h5 {
    color: #888888;
}

.system-jump-error {
    background: #fff0f0;
}

.system-jump-error>h5 {
    color: #d70000;
}

.system-jump-loading {
    background: #e8ecff;
}

.system-jump-loading>h5 {
    color: #36befa;
}
</style>
<div class="container">
	<?php switch($msg): case "site_close": ?>
	        <div class="card my-5">
	            <div class="card-header">站点关闭</div>
	            <div class="card-body"><?php echo htmlentities($_G['setting']['site_close_tip']); ?></div>
	        </div>
		<?php break; case "login": ?>
	        <div class="my-5 mx-auto" style="width: 25rem">
	            <form method="post" action="<?php echo url('user/account/login'); ?>">
	                <input type="hidden" name="referer" value="<?php echo htmlentities(app('request')->url(true)); ?>">
	                <div class="card">
	                    <div class="card-header">请先登陆后再操作</div>
	                    <div class="card-body">
	                        <div class="form-group">
	                            <label>账户：</label>
	                            <input type="text" class="form-control" name="username" placeholder="邮箱/手机号/用户名" required>
	                        </div>
	                        <div class="form-group">
	                            <label>密码：</label>
	                            <input type="password" class="form-control" name="password" placeholder="账户密码" required>
	                        </div>
	                        <button class="btn btn-success d-block w-100 btn-submit ajax-post">登 陆</button>
	                    </div>
	                    <div class="card-footer clearfix">
	                        <div class="float-left">
	                            <a href="<?php echo url('user/account/forget'); ?>">忘记密码</a>
	                        </div>
	                        <div class="float-right">
	                            还没有帐号？ <a href="<?php echo url('user/account/'.$_G['setting']['register_action']); ?>">立即注册&gt;&gt;</a>
	                        </div>
	                    </div>
	                </div>
	            </form>
	        </div>
		<?php break; default: ?>
	        <div class="system-jump-box">
	            <div class="system-jump-message system-jump-<?php echo htmlentities($show_class); ?> p-3">
	                <h5>
	                    <?php switch($code): case "-1": ?><i class="adt-icon system-jump-icon icon-show-error"></i><?php break; case "2": ?><i class="adt-icon system-jump-icon icon-show-loading"></i><?php break; case "1": ?><i class="adt-icon system-jump-icon icon-show-right"></i><?php break; default: ?><i class="adt-icon system-jump-icon icon-show-info"></i>
	                    <?php endswitch; ?>
	                    <?php echo strip_tags($msg); ?>
	                </h5>
	                <?php if($code === 2): ?>
	                    <div class="progress mb-2">
	                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success w-100"></div>
	                    </div>
	                <?php endif; ?>
	                <div class="system-jump form-text text-muted">
	                    页面将在<b id="system-jump-wait"><?php echo htmlentities($wait); ?></b>秒后跳转，<a id="system-jump-href" href="<?php echo htmlentities($url); ?>">点击这里快速跳转</a>
	                </div>
	            </div>
	        </div>
	        <script>
                $(function(){
                    var wait = <?php echo htmlentities($wait); ?>,
                        href = $('#system-jump-href').attr('href');
                    if(parseInt(wait) <= 0){
                        location.href = href;
                    }else{
                        var interval = setInterval(function(){
                            wait--;
                            $('#system-jump-wait').html(wait);
                            if(wait <= 0) {
                                clearInterval(interval);
                                location.href = href;
                            };
                        }, 1000);
                    }
                })
	        </script>
	<?php endswitch; ?>
</div>
</div>
</div>
<script type="text/javascript" src="static/js/common.js"></script>
</body>
</html>
