<?php /*a:2:{s:50:"D:\www\sucai\application\admin\view\card_index.php";i:1555074906;s:46:"D:\www\sucai\application\admin\view\layout.php";i:1555066292;}*/ ?>
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
            <a class="btn btn-primary btn-sm" href="<?php echo url('admin/card/create'); ?>">新增充值卡</a>
            <a class="btn btn-primary btn-sm" href="<?php echo url('admin/card/export'); ?>">导出充值卡</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover table-card mb-0">
            <thead>
                <tr>
                    <th scope="col">卡号</th>
                    <th width="200" scope="col">创建用户</th>
                    <th width="400" scope="col">卡密功能</th>
                    <th width="200" scope="col">充值用户</th>
                    <th width="80" scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($card_list) || $card_list instanceof \think\Collection || $card_list instanceof \think\Paginator): $i = 0; $__LIST__ = $card_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$card): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td class="text-success Clipboard" data-toggle="tooltip" data-placement="top" title="" data-original-title="点击复制卡密" data-clipboard-text="<?php echo htmlentities($card['card_id']); ?>"><?php echo htmlentities($card['card_id']); ?></td>
                        <td data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo htmlentities($card['create_time']); ?>"><?php echo htmlentities($card['create_user']['username']); ?></td>
                        <td><?php echo $card['info']; ?></td>
                        <td <?php if(!empty($card['use_uid'])): ?>data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo htmlentities($card['use_time']); ?>"<?php endif; ?>>
                            <?php if(empty($card['use_uid'])): ?>
                                未使用
                            <?php else: ?>
                                <?php echo htmlentities($card['use_user']['username']); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="ajax-link" data-mode="confirm" href="<?php echo url('admin/card/delete',['card_id'=>$card['card_id']]); ?>">删除</a>
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
<script type="text/javascript">
    $(function(){
        $(document)
            .on('click','.show-access-times',function(){
                var access = $(this).data('access-times');
                var message = '';
                $.each(access,function(index,value){
                    message += value.title+': 日解析+'+value.day+' 总解析+'+value.all+'<br>';
                })
                dialog.alert(message, {
                    title:'站点权限',
                });
            })
    })
</script>
</div>
</div>
<script type="text/javascript" src="static/js/common.js"></script>
</body>
</html>
