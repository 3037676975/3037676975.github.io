<?php /*a:1:{s:58:"D:\www\sucai\application\index\view\common_showmessage.php";i:1554964164;}*/ ?>
<?php
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
<div class="container my-5">
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
