<?php /*a:2:{s:53:"D:\www\sucai\application\admin\view\setting_index.php";i:1556028101;s:46:"D:\www\sucai\application\admin\view\layout.php";i:1555066292;}*/ ?>
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
	<div class="p-3"><form class="card" method="post" action="<?php echo url('admin/setting/index'); ?>">
	<div class="card-header">基础设置</div>
	<div class="card-body">
		<div class="form-group">
			<label>网站名称</label>
			<input type="text" class="form-control" name="setting[site_name]" value="<?php echo htmlentities($_G['setting']['site_name']); ?>">
			<small class="form-text text-muted">将显示在浏览器窗口标题等位置</small>
		</div>
		<div class="form-group">
			<label>管理员QQ</label>
			<input type="text" class="form-control" name="setting[qq]" value="<?php echo htmlentities($_G['setting']['qq']); ?>">
			<small class="form-text text-muted">作为系统发邮件的时候的发件人地址</small>
		</div>
		<div class="form-group">
			<label>阿里云OSS AccessKeyId</label>
			<input type="text" class="form-control" name="setting[AccessKeyId]" value="<?php echo htmlentities($_G['setting']['AccessKeyId']); ?>">
			<small class="form-text text-muted">如果不启用OSS存储则该项可不填</small>
		</div>
		<div class="form-group">
			<label>阿里云OSS AccessKeySecret</label>
			<input type="text" class="form-control" name="setting[AccessKeySecret]" value="<?php echo htmlentities($_G['setting']['AccessKeySecret']); ?>">
			<small class="form-text text-muted">如果不启用OSS存储则该项可不填</small>
		</div>
		<div class="form-group">
			<label>阿里云OSS Endpoint</label>
			<input type="text" class="form-control" name="setting[Endpoint]" value="<?php echo htmlentities($_G['setting']['Endpoint']); ?>">
			<small class="form-text text-muted">如果不启用OSS存储则该项可不填</small>
		</div>
		<div class="form-group">
			<label>阿里云OSS Bucket</label>
			<input type="text" class="form-control" name="setting[Bucket]" value="<?php echo htmlentities($_G['setting']['Bucket']); ?>">
			<small class="form-text text-muted">如果不启用OSS存储则该项可不填</small>
		</div>
		<div class="form-group">
			<label>解析间隔时间</label>
			<input type="text" class="form-control" name="setting[parse_between_time]" value="<?php echo htmlentities($_G['setting']['parse_between_time']); ?>">
			<small class="form-text text-muted">同一用户两次解析间隔时间，单位秒，建议值60</small>
		</div>
		<div class="form-group">
			<label>代理用户最多可生成卡密张数</label>
			<input type="text" class="form-control" name="setting[proxy_card_numbers]" value="<?php echo htmlentities($_G['setting']['proxy_card_numbers']); ?>">
			<small class="form-text text-muted">代理用户最多可生成卡密张数</small>
		</div>
		<div class="form-group">
			<label>代理用户最多可增加账户总解析次数</label>
			<input type="text" class="form-control" name="setting[proxy_card_account_times]" value="<?php echo htmlentities($_G['setting']['proxy_card_account_times']); ?>">
			<small class="form-text text-muted">代理用户最多可增加账户总解析次数</small>
		</div>
		<div class="form-group">
			<label>代理用户生成卡密的规则</label>
			<input type="text" class="form-control" name="setting[proxy_card_rule]" value="<?php echo htmlentities($_G['setting']['proxy_card_rule']); ?>">
			<div class="form-text text-muted small">"@"代表任意随机英文字符，"#"代表任意随机数字，"*"代表任意英文或数字</div>
			<div class="form-text text-muted small">规则样本：<strong class="text-success">@@@@@#####*****</strong></div>
			<div class="form-text text-muted small">注意：规则位数过小会造成用户名生成重复概率增大，过多的重复用户名会造成用户名生成终止</div>
			<div class="form-text text-muted small">用户名规则中不能带有中文及其他特殊符号</div>
			<div class="form-text text-muted small">为了避免用户名重复，随机位数最好不要少于8位</div>
		</div>
		<div class="form-group">
			<label>开启网站</label>
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" name="setting[site_open]" value="1" <?php if($_G['setting']['site_open']): ?>checked<?php endif; ?>>
				<label class="custom-control-label">启用网站</label>
			</div>
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" name="setting[site_open]" value="0" <?php if(!$_G['setting']['site_open']): ?>checked<?php endif; ?>>
				<label class="custom-control-label">关闭网站</label>
			</div>
			<small class="form-text text-muted">暂时将站点关闭，其他人无法访问，但不影响管理员访问</small>
		</div>
		<div class="form-group">
			<label>允许注册新用户</label>
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" name="setting[allow_register]" value="1" <?php if($_G['setting']['allow_register']): ?>checked<?php endif; ?>>
				<label class="custom-control-label">允许注册</label>
			</div>
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" name="setting[allow_register]" value="0" <?php if(!$_G['setting']['allow_register']): ?>checked<?php endif; ?>>
				<label class="custom-control-label">禁止注册</label>
			</div>
			<small class="form-text text-muted">关闭注册后用户无法在前台自行注册</small>
		</div>
	</div>
	<div class="card-footer">
		<button type="button" class="btn btn-success btn-submit ajax-post">保存设置</button>
	</div>
</form>
</div>
</div>
<script type="text/javascript" src="static/js/common.js"></script>
</body>
</html>
