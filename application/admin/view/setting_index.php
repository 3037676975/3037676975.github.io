<form class="card" method="post" action="{:url('admin/setting/index')}">
	<div class="card-header">基础设置</div>
	<div class="card-body">
		<div class="form-group">
			<label>网站名称</label>
			<input type="text" class="form-control" name="setting[site_name]" value="{$_G['setting']['site_name']}">
			<small class="form-text text-muted">将显示在浏览器窗口标题等位置</small>
		</div>
		<div class="form-group">
			<label>管理员QQ</label>
			<input type="text" class="form-control" name="setting[qq]" value="{$_G['setting']['qq']}">
			<small class="form-text text-muted">作为系统发邮件的时候的发件人地址</small>
		</div>
		<div class="form-group">
			<label>阿里云OSS AccessKeyId</label>
			<input type="text" class="form-control" name="setting[AccessKeyId]" value="{$_G['setting']['AccessKeyId']}">
			<small class="form-text text-muted">如果不启用OSS存储则该项可不填</small>
		</div>
		<div class="form-group">
			<label>阿里云OSS AccessKeySecret</label>
			<input type="text" class="form-control" name="setting[AccessKeySecret]" value="{$_G['setting']['AccessKeySecret']}">
			<small class="form-text text-muted">如果不启用OSS存储则该项可不填</small>
		</div>
		<div class="form-group">
			<label>阿里云OSS Endpoint</label>
			<input type="text" class="form-control" name="setting[Endpoint]" value="{$_G['setting']['Endpoint']}">
			<small class="form-text text-muted">如果不启用OSS存储则该项可不填</small>
		</div>
		<div class="form-group">
			<label>阿里云OSS Bucket</label>
			<input type="text" class="form-control" name="setting[Bucket]" value="{$_G['setting']['Bucket']}">
			<small class="form-text text-muted">如果不启用OSS存储则该项可不填</small>
		</div>
		<div class="form-group">
			<label>解析间隔时间</label>
			<input type="text" class="form-control" name="setting[parse_between_time]" value="{$_G['setting']['parse_between_time']}">
			<small class="form-text text-muted">同一用户两次解析间隔时间，单位秒，建议值60</small>
		</div>
		<div class="form-group">
			<label>代理用户最多可生成卡密张数</label>
			<input type="text" class="form-control" name="setting[proxy_card_numbers]" value="{$_G['setting']['proxy_card_numbers']}">
			<small class="form-text text-muted">代理用户最多可生成卡密张数</small>
		</div>
		<div class="form-group">
			<label>代理用户最多可增加账户总解析次数</label>
			<input type="text" class="form-control" name="setting[proxy_card_account_times]" value="{$_G['setting']['proxy_card_account_times']}">
			<small class="form-text text-muted">代理用户最多可增加账户总解析次数</small>
		</div>
		<div class="form-group">
			<label>代理用户生成卡密的规则</label>
			<input type="text" class="form-control" name="setting[proxy_card_rule]" value="{$_G['setting']['proxy_card_rule']}">
			<div class="form-text text-muted small">"@"代表任意随机英文字符，"#"代表任意随机数字，"*"代表任意英文或数字</div>
			<div class="form-text text-muted small">规则样本：<strong class="text-success">@@@@@#####*****</strong></div>
			<div class="form-text text-muted small">注意：规则位数过小会造成用户名生成重复概率增大，过多的重复用户名会造成用户名生成终止</div>
			<div class="form-text text-muted small">用户名规则中不能带有中文及其他特殊符号</div>
			<div class="form-text text-muted small">为了避免用户名重复，随机位数最好不要少于8位</div>
		</div>
		<div class="form-group">
			<label>开启网站</label>
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" name="setting[site_open]" value="1" {if $_G['setting']['site_open']}checked{/if}>
				<label class="custom-control-label">启用网站</label>
			</div>
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" name="setting[site_open]" value="0" {if !$_G['setting']['site_open']}checked{/if}>
				<label class="custom-control-label">关闭网站</label>
			</div>
			<small class="form-text text-muted">暂时将站点关闭，其他人无法访问，但不影响管理员访问</small>
		</div>
		<div class="form-group">
			<label>允许注册新用户</label>
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" name="setting[allow_register]" value="1" {if $_G['setting']['allow_register']}checked{/if}>
				<label class="custom-control-label">允许注册</label>
			</div>
			<div class="custom-control custom-radio">
				<input type="radio" class="custom-control-input" name="setting[allow_register]" value="0" {if !$_G['setting']['allow_register']}checked{/if}>
				<label class="custom-control-label">禁止注册</label>
			</div>
			<small class="form-text text-muted">关闭注册后用户无法在前台自行注册</small>
		</div>
	</div>
	<div class="card-footer">
		<button type="button" class="btn btn-success btn-submit ajax-post">保存设置</button>
	</div>
</form>
