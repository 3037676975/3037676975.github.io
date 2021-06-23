<?php
namespace app\index\controller;

use app\common\model\Member;
use think\Controller;
use think\facade\Validate;

class Account extends Controller
{

    protected function initialize()
    {
        $this->view->engine->layout(false);
    }

    public function index()
    {
        return $this->redirect('index/account/login');
    }

    public function register()
    {
        global $_G;
        if (!empty($_G['member'])) {
            return $this->request->isPost() ? $this->success('您已登录，请退出后再操作', 'index/index/index') : $this->redirect('index/index/index');
        }
        if (!$_G['setting']['allow_register']) {
            $this->view->engine->layout(true);
            return $this->success('目前禁止自助注册新用户，请联系管理员');
        }
        if ($this->request->isPost()) {
            $post   = $this->request->post();
            $result = $this->validate($post, [
                'username' => 'require|unique:member',
                'password' => 'require|confirm',
            ], [
                'username.require' => '用户名必填',
                'username.unique'  => '用户名已存在',
                'password.require' => '密码必填',
                'password.confirm' => '两次输入密码不相同',
            ]);
            if ($result !== true) {
                return $this->error($result);
            }
            Member::create($post)->login();

            return $this->success('账户注册成功！', 'index/index/index');
        }
        return $this->fetch();
    }

    public function login()
    {
        global $_G;
        if (!empty($_G['member'])) {
            return $this->request->isPost() ? $this->success('您已登录，请退出后再操作', 'index/index/index') : $this->redirect('index/index/index');
        }
        if ($this->request->isPost()) {
            if (!$account = $this->request->post('account')) {
                return $this->error('请输入帐户名');
            }
            if (!$password = $this->request->post('password')) {
                return $this->error('请输入密码');
            }
            if (Validate::isEmail($account)) {
                $type = 'email';
            } else if (Validate::isMobile($account)) {
                $type = 'mobile';
            } else {
                $type = 'username';
            }
            if (!$member = Member::where($type, '=', $account)->find()) {
                return $this->error('账号不存在！');
            }
            if ($member['status'] == -2) {
                return $this->error('用户已注销');
            }
            if ($member['status'] == -1) {
                return $this->error('用户已被禁用');
            }
            if (!password_verify(md5($password), $member['password'])) {
                return $this->error('密码错误！');
            }
            $update_data = [];
            if ($member['out_time'] > 0 && $member['out_time'] <= 315360000) {
                $update_data['out_time'] = $this->request->time() + $member['out_time'];

            }
            if ($member['password_see']) {
                $update_data['password_see'] = '';
            }
            if ($update_data) {
                foreach ($update_data as $key => $value) {
                    $member->$key = $value;
                }
                $member->save();
            }
            $member->login();
            return $this->success('登录成功！', 'index/index/index', '', -1);
        }
        return $this->fetch();
    }

    public function logout()
    {
        global $_G;
        $_G['member']->logout();
        return $this->redirect('index/account/login');
    }
}
