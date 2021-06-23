<div class="row my-5">
	{include file="user/left"}
	<div class="col-10">
		{if $_G['member']['out_time'] > 0}
			{if $_G['member']['out_time'] <= request()->time()}
				<div class="alert alert-danger">您的账号已于 <strong>{:date('Y-m-d H:i',$_G['member']['out_time'])}</strong> 过期，无法继续解析素材，请联系管理员！</div>
			{else}
				<div class="alert alert-success">您的账号有效期至： <strong>{:date('Y-m-d H:i',$_G['member']['out_time'])}</strong> 当前可正常解析素材</div>
			{/if}
		{elseif $_G['member']['out_time'] == 0 && $_G['member']['type'] != 'system'}
			<div class="alert alert-success">您的账号为永久会员，当前可正常解析素材</div>
		{/if}
		<div class="card">
			<div class="card-header">我的权限 (每日凌晨00:00更新下载次数)</div>
			<div class="card-body p-0">
				<table class="table table-striped table-hover mb-0">
					<colgroup>
						<col width="150">
						<col>
					</colgroup>
					<tbody>
						{volist name="site_list" id="site" key="i"}
							{php}$site_id = $site['site_id'];{/php}
							<tr>
								<td class="{if $i == 1}border-top-0{/if} text-success" align="right">{$site['title']} ： </td>
								<td {if $i == 1}class="border-top-0"{/if}>
									今日已解析：<strong class="text-danger pr-3">{$_G['member']->site_access->$site_id->day_used??0}次</strong>
									每日可解析：<strong class="text-info pr-3">{$_G['member']->site_access->$site_id->day??0}次</strong>
									共解析：<strong class="text-danger pr-3">{$_G['member']->site_access->$site_id->max_used??0}次</strong>
									总解析次数：<strong class="text-info pr-3">{$_G['member']->site_access->$site_id->all??0}次</strong>
								</td>
							</tr>
						{/volist}
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
