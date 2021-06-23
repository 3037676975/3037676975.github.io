<?php
namespace app\common\model;

use app\common\model\WebSite;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;
use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    use SoftDelete;
    protected $pk                 = 'uid';
    protected $autoWriteTimestamp = true;
    protected $createTime         = 'register_time';
    protected $insert             = ['register_ip', 'last_time', 'last_ip', 'site_access'];
    protected $updateTime         = '';
    protected $deleteTime         = 'delete_time';
    protected $defaultSoftDelete  = 0;
    protected $json               = ['site_access'];

    public static function init()
    {
    }

    protected function setPasswordAttr($value)
    {
        return password_hash(md5($value), PASSWORD_DEFAULT);
    }

    protected function setRegisterTimeAttr($value)
    {
        return Request::time();
    }

    protected function setRegisterIpAttr($value)
    {
        return Request::ip();
    }

    protected function setLastTimeAttr($value)
    {
        return Request::time();
    }

    protected function setLastIpAttr($value)
    {
        return Request::ip();
    }

    protected function setSiteAccess($value)
    {
        if (empty($value) || !is_array($value)) {
            $result = [];
            foreach (WebSite::select() as $site) {
                $result[$site['site_id']] = ['used' => 0, 'all' => 0];
            }
            return $result;
        }
        return $value;
    }

    public function getStatusTextAttr($value, $data)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$data['status']];
    }

    public function getTypeTextAttr($value, $data)
    {
        $type = ['system' => '管理员', 'proxy' => '代理', 'member' => '会员'];
        return $type[$data['type']];
    }

    public function login($auto = true)
    {
        global $_G;
        if (empty($this->uid)) {
            return false;
        }
        $this->last_time = Request::time();
        $this->last_ip   = Request::ip();
        $this->save();
        if ($this->reset_times < date('Ymd')) {
            $this->reset_times();
        }
        $info = [
            'uid'       => $this->uid,
            'password'  => md5($this->password),
            'last_time' => $this->last_time,
        ];
        Session::set('uid', $info);
        if ($auto) {
            Cookie::set('uid', authcode(base64_encode(json_encode($info)), 'ECODE'), 2592000);
        }
        $_G['member'] = $this;
        return true;
    }

    public function reset_times()
    {
        $site_access = [];
        foreach (json_decode(json_encode($this->site_access), true) as $site_id => $access) {
            $site_access[$site_id] = ['day_used' => '0', 'max_used' => $access['max_used'], 'day' => $access['day'], 'all' => $access['all']];
        }
        $this->reset_times = date('Ymd');
        $this->site_access = $site_access;
        $this->save();
    }

    public function logout()
    {
        global $_G;
        Session::delete('uid');
        Cookie::delete('uid');
        $_G['uid']    = 0;
        $_G['member'] = false;
        return true;

    }
}
