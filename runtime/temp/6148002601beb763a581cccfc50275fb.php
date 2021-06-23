<?php /*a:1:{s:53:"D:\www\sucai\application\admin\view\account_login.php";i:1554927518;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>管理中心</title>
	<base href="<?php echo htmlentities($_G['site_url']); ?>">
	<script src="static/js/jquery-3.3.1.min.js"></script>
	<script src="static/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="static/css/common.css">
	<link rel="stylesheet" type="text/css" href="static/css/signin.css">
</head>
<body class="text-center">
	<form class="form-signin" autocomplete="off">
		<h1 class="h3 mb-3 font-weight-normal">管理登录</h1>
		<label for="account" class="sr-only">账号</label>
		<input type="text" id="account" class="form-control" name="account" placeholder="管理员账号" required autofocus>
		<label for="password" class="sr-only">密码</label>
		<input type="password" id="password" class="form-control" name="password" placeholder="账号密码" required>
		<button class="btn btn-lg btn-primary btn-block btn-submit ajax-post mt-3" type="submit">登录</button>
		<p class="mt-5 mb-3 text-muted">&copy; 2019-2099</p>
	</form>
<script type="text/javascript" src="static/js/common.js"></script>
</body>
</html>
