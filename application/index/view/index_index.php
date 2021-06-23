<div class="url-box">
	<input type="text" class="url-text" placeholder="需要解析的链接地址" spellcheck="false">
	<div class="submit">解 析</div>
</div>
<div class="download-url-box text-center d-none mb-5"></div>
<div class="card user-power mb-5">
	<div class="card-header">支持的素材（资源）网站</div>
	<div class="card-body">
		<div class="site-list">
			{foreach $site_list as $site}
				<span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="官网：{$site['url']}">{$site['title']}</span>
			{/foreach}
		</div>
		<p style="margin-top: 10px;">部分资源为独立收费资源，目前暂不支持该部分资源的解析！</p>
	</div>
</div>
<script>
	$(function(){
		$(document)
			.on('click','.submit',function(){
				$('.download-url-box').html('<p>正在努力解析中...</p>');
				var link = $.trim($('.url-text').val());
				if(!link){
					$('.url-text').focus();
					return dialog.msg('请输入需要解析的网址');
				}
				$(this).addClass('disabled').html('解析中...');
				$.ajax({
					url:'{:url('index/index/parse')}',
					data:{link:link},
					dataType:'json',
					type:'POST',
					success:function(s){
						console.log(s);
						if(s.code == 1){
							var urllist = '';
							$.each(s.data,function(name,url){
								urllist += '<a class="btn btn-danger '+(urllist != '' ? 'ml-3' : '')+'" href="'+url+'">'+name+'</a>';
							})
							$('.download-url-box').removeClass('d-none').html(urllist).show();
						}else{
							$('.download-url-box').removeClass('d-none').html(s.msg).show();
						}
		                dialog.msg(s.msg);
					},
		            complete:function(request, status){
		                $('.submit').removeClass('disabled').html('解 析');
		                if(status == 'error'){
		                    dialog.msg('页面错误，请联系管理员！');
		                }else if(status == 'timeout'){
		                    dialog.msg('数据提交超时，请稍后再试！');
		                }
		            }
				})
			})
	})
</script>
