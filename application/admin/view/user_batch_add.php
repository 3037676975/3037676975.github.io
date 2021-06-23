<form class="card" method="post" autocomplete="off" action="{:url('admin/user/batch_add')}">
    <div class="card-header">批量增加会员</div>
    <div class="card-body">
        <div class="form-group">
            <label>用户名规则</label>
            <input type="text" name="username" class="form-control">
			<div class="form-text text-muted small">"@"代表任意随机英文字符，"#"代表任意随机数字，"*"代表任意英文或数字</div>
			<div class="form-text text-muted small">规则样本：<strong class="text-success">@@@@@#####*****</strong></div>
			<div class="form-text text-muted small">注意：规则位数过小会造成用户名生成重复概率增大，过多的重复用户名会造成用户名生成终止</div>
			<div class="form-text text-muted small">用户名规则中不能带有中文及其他特殊符号</div>
			<div class="form-text text-muted small">为了避免用户名重复，随机位数最好不要少于8位</div>
        </div>
        <div class="form-group">
            <label>登陆密码</label>
            <input type="text" name="password" class="form-control">
			<div class="form-text text-muted small">"@"代表任意随机英文字符，"#"代表任意随机数字，"*"代表任意英文或数字</div>
			<div class="form-text text-muted small">规则样本：<strong class="text-success">@@@@@#####*****</strong></div>
        </div>
        <div class="form-group">
            <label>生成数量</label>
            <input type="number" name="numbers" class="form-control" value="10">
			<div class="form-text text-muted small">每次生成数据建议在100以内</div>
        </div>
        <div class="form-group">
            <label>最大解析次数</label>
            <input type="number" name="parse_max_times" class="form-control" value="0">
            <small class="form-text text-muted">当前账户拥有的最大解析次数，填0为无限制</small>
            <small class="form-text text-muted">此权限高于单站点解析限制权限，例如我图网最高可解析20次，但次数填写10，那么解析十次后账户便不可在解析任何站点</small>
        </div>
        <div class="form-group">
            <label>过期时间</label>
            <input type="number" name="out_time" class="form-control" value="0">
            <small class="form-text text-muted">单位小时，如果填写0，那么账户永久有效</small>
            <small class="form-text text-muted">例如：填写72，那么当该账户第一次登录时开始计算时间，72小时候过期，最大值：87600</small>
        </div>
        <div class="form-group">
            <label>账户类型</label>
            <select class="form-control" name="type">
                <option value="member" selected>会员</option>
                <option value="proxy">代理</option>
            </select>
            <small class="form-text text-muted">管理员可进入后台，请谨慎选择！</small>
            <small class="form-text text-muted">代理用户可在前台生成充值卡密，普通会员仅可解析资源</small>
            <small class="form-text text-muted">不能批量增加管理员</small>
        </div>
        {foreach $site_list as $site}
            <input type="hidden" name="site_access[{$site['site_id']}][day_used]" value="0">
            <input type="hidden" name="site_access[{$site['site_id']}][max_used]" value="0">
            <div class="form-group d-flex justify-content-between">
                <div class="my-1 mr-3 text-right" style="width: 180px;">{$site['title']}</div>
                <div class="input-group mr-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">日解析最大次数</div>
                    </div>
                    <input type="number" class="form-control" name="site_access[{$site['site_id']}][day]" placeholder="日解析最大次数" value="0">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">最大次数</div>
                    </div>
                    <input type="number" class="form-control" name="site_access[{$site['site_id']}][all]" placeholder="最大次数" value="0">
                </div>
            </div>
        {/foreach}
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-success btn-submit ajax-post">提交数据</button>
    </div>
</form>
