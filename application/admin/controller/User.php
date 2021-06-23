<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\common\model\Member;
use app\common\model\WebSite;
use think\facade\Validate;

class User extends Base
{
    public function index()
    {
        $where                 = [];
        $this->view->user_list = Member::where($where)->order('uid desc')->paginate(30);
        $this->view->page      = $this->view->user_list->render();
        return $this->fetch();
    }

    public function create()
    {
        if ($this->request->isPost()) {
            $post   = $this->request->post();
            $result = $this->validate($post, [
                'username' => 'require|unique:member',
                'password' => 'require',
                'email'    => 'unique:member',
                'mobile'   => 'unique:member',
                'out_time' => 'require|integer|>=:0|<=:87600',
            ], [
                'username.require' => '用户名必填',
                'username.unique'  => '用户名已存在',
                'password.require' => '密码必填',
                'email'            => '邮箱已存在',
                'mobile'           => '手机号已存在',
                'out_time'         => '账户有效期填写错误',
            ]);
            if ($result !== true) {
                return $this->error($result);
            }
            $post['out_time'] = $post['out_time'] * 3600;
            Member::create($post);
            return $this->success('会员添加成功');
        }

        $this->view->site_list = WebSite::select();
        return $this->fetch();
    }

    public function edit($uid = 0)
    {
        $user = Member::where('uid', '=', $uid)->find();
        if (empty($user)) {
            return $this->error('指定数据不存在');
        }
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (empty($post['password'])) {
                unset($post['password']);
            }
            $result = $this->validate($post, [
                'username' => 'require|unique:member',
                'email'    => 'unique:member',
                'mobile'   => 'unique:member',
            ], [
                'username.require' => '用户名必填',
                'username.unique'  => '用户名已存在',
                'email'            => '邮箱已存在',
                'mobile'           => '手机号已存在',
            ]);
            if ($result !== true) {
                return $this->error($result);
            }
            if (!Validate::isNumber($post['out_time'])) {
                $post['out_time'] = strtotime($post['out_time']);
            } else {
                $post['out_time'] = $post['out_time'] * 3600;
            }
            $user->allowField(true)->save($post, ['uid' => $user['uid']]);
            return $this->success('会员数据编辑成功！');
        }

        $this->view->site_list = WebSite::select();
        $this->view->user      = $user;
        return $this->fetch();
    }

    public function batch_add()
    {
        if ($this->request->isPost()) {
            $post   = $this->request->post();
            $result = $this->validate($post, [
                'username' => 'require',
                'password' => 'require',
                'numbers'  => 'require|integer|>:0|<=:200',
                'out_time' => 'require|integer|>=:0|<=:87600',
            ], [
                'username.require' => '用户名必填',
                'username.unique'  => '用户名已存在',
                'password.require' => '密码必填',
                'numbers'          => '生成数量只能是1-200之间的整数',
                'out_time'         => '账户有效期填写错误',
            ]);
            if ($result !== true) {
                return $this->error($result);
            }
            $username = $password = [];
            for ($i = 0; $i < $post['numbers']; $i++) {
                $username[$i] = replace_random_str($post['username']);
                $password[$i] = replace_random_str($post['password']);
            }
            foreach (Member::where('username', 'in', $username)->field('uid,username')->select() as $old) {
                $k = array_search($old['username'], $username);
                unset($username[$k]);
            }
            foreach ($username as $k => $name) {
                Member::create([
                    'username'        => $name,
                    'password'        => strtolower($password[$k]),
                    'password_see'    => strtolower($password[$k]),
                    'out_time'        => $post['out_time'] * 3600,
                    'site_access'     => $post['site_access'],
                    'from'            => 'batch_add',
                    'parse_max_times' => (int) $post['parse_max_times'],
                ]);
            }

            return $this->success('本次成功生成' . count($username) . '个账号！', 'admin/user/index');
        }

        $this->view->site_list = WebSite::select();
        return $this->fetch();
    }

    public function export()
    {
        return $this->success('功能开发中..');
    }

    public function delete($uid = 0)
    {
        if (!$this->request->isAjax()) {
            return $this->error('请求类型错误');
        }
        if (in_array($uid, config('app.founder'))) {
            return $this->error('超级管理员无法删除，请先从配置文件中移除该管理员');
        }
        $user = Member::where('uid', '=', $uid)->find();
        if (empty($user)) {
            return $this->error('指定数据不存在');
        }
        $user->delete();
        return $this->success('会员删除成功');
    }
}
