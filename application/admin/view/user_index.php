<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="">
            <a class="btn btn-primary btn-sm" href="{:url('admin/user/create')}">新增会员</a>
            <a class="btn btn-primary btn-sm" href="{:url('admin/user/batch_add')}">批量添加会员</a>
            <a class="btn btn-primary btn-sm" href="{:url('admin/user/export')}">导出会员</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover table-card mb-0">
            <thead>
                <tr>
                    <th scope="col">UID</th>
                    <th scope="col">用户名</th>
                    <th scope="col">注册时间</th>
                    <th scope="col">过期时间</th>
                    <th width="80" scope="col">类型</th>
                    <th scope="col">状态</th>
                    <th width="90" scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                {volist name="user_list" id="user"}
                    <tr>
                        <td>{$user['uid']}</td>
                        <td {if $user['password_see']}class="text-success Clipboard" data-toggle="tooltip" data-placement="top" title="" data-original-title="点击复制账号和密码" data-clipboard-text="账号：{$user['username']} 密码：{$user['password_see']}"{/if}>{$user['username']}{if $user['password_see']}<strong class="pl-3">{$user['password_see']}</strong>{/if}</td>
                        <td>{$user['register_time']}</td>
                        <td>
                            {if $user['out_time'] == 0}
                                永久有效
                            {elseif $user['out_time'] > 0}
                                {if $user['out_time'] <= 315360000}
                                    {$user['out_time']/3600}小时
                                {else}
                                    {:date('Y-m-d H:i:s',$user['out_time'])}
                                {/if}

                            {/if}
                        </td>
                        <td>{$user['type_text']}</td>
                        <td>{$user['status_text']}</td>
                        <td>
                            <a href="{:url('admin/user/edit',['uid'=>$user['uid']])}">编辑</a>
                            <a class="ajax-link" data-mode="confirm" href="{:url('admin/user/delete',['uid'=>$user['uid']])}">删除</a>
                        </td>
                    </tr>
                {/volist}
            </tbody>
        </table>
    </div>
    {if $page}
        <div class="card-footer">{$page|raw}</div>
    {/if}
</div>
