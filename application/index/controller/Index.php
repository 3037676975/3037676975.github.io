<?php
namespace app\index\controller;

use app\common\model\Attach;
use app\common\model\MemberLog;
use app\common\model\ParseUrl;
use app\common\model\WebSite;
use app\common\model\WebSiteCookie;
use think\Controller;

class Index extends Controller
{

    protected function initialize()
    {
        global $_G;
        $this->view->site_list = WebSite::where('status', '>', 0)->select();
    }

    public function index()
    {
        return $this->fetch();
    }

    public function parse($link = '')
    {
        global $_G;
        if (empty($link)) {
            return $this->error('请输入需要解析的网址');
        }
        if (empty($_G['member'])) {
            return $this->error('请先登陆后再使用此功能');
        }
        if ($_G['member']['out_time'] > 0 && $_G['member']['out_time'] <= request()->time()) {
            return $this->error('您的账户已过期，请联系管理员！');
        }
        if ($_G['member']['parse_max_times'] > 0 && $_G['member']['parse_times'] >= $_G['member']['parse_max_times']) {
            return $this->error('您的账户解析次数已达上限，请充值');
        }
        $site    = '';
        $site_id = 0;
        foreach ($this->view->site_list as $data) {
            if (stripos($link, $data['url_regular']) !== false) {
                $site    = $data;
                $site_id = $data['site_id'];
                break;
            }
        }
        $cookie = WebSiteCookie::where('site_id', '=', $site_id)->find();
        if (empty($site) || empty($cookie) || $site['status'] != 1) {
            return $this->error('暂不支持该网址的解析！');
        }
        if (intval($_G['member']->site_access->$site_id->day) > 0 && $_G['member']->site_access->$site_id->day_used >= $_G['member']->site_access->$site_id->day) {
            return $this->error('目标网站今日的解析次数已用完，试试其他网站吧');
        }
        if (intval($_G['member']->site_access->$site_id->all) > 0 && $_G['member']->site_access->$site_id->max_used >= $_G['member']->site_access->$site_id->all) {
            return $this->error('目标站解析次数已达上限，请联系客服充值');
        }
        $action   = 'get_' . str_replace('.', '_', $site['url_regular']);
        $ParseUrl = new ParseUrl($link, $site, $cookie);
        if (!method_exists($ParseUrl, $action)) {
            return $this->error('暂不支持该网址的解析！');
        }
        $result = $ParseUrl->$action();
        if ($result['code'] !== 1) {
            return $this->error($result['msg']);
        }
        if (empty($result['has_attach'])) {
            foreach ($result['msg'] as $button_name => $download_url) {
                Attach::create([
                    'site_id'        => $site_id,
                    'request_url'    => $link,
                    'site_code_type' => $result['site_code_type'],
                    'site_code'      => $result['site_code'],
                    'response_url'   => $download_url,
                    'button_name'    => $button_name,
                    'queue_error'    => '',
                ]);
            }
        }
        MemberLog::create([
            'uid'       => $_G['member']['uid'],
            'site_id'   => $site_id,
            'times'     => 1,
            'status'    => 1,
            'parse_url' => $link,
        ]);
        $_G['member']->site_access->$site_id->day_used = $_G['member']->site_access->$site_id->day_used + 1;
        $_G['member']->site_access->$site_id->max_used = $_G['member']->site_access->$site_id->max_used + 1;
        $_G['member']->parse_times                     = $_G['member']->parse_times + 1;
        $_G['member']->save();
        return $this->success('解析成功！', '', $result['msg']);
    }

    public function demo()
    {
        return $this->fetch();
    }

    public function jietu()
    {
        return $this->fetch();
    }

    public function price()
    {
        return $this->fetch();
    }
}
