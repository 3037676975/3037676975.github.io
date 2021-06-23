<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\common\model\WebSite;
use think\facade\Cache;

class Tools extends Base
{

    public function index()
    {

        Cache::rm('web_site');
        $web_site = [];
        foreach (WebSite::select()->toArray() as $site) {
            $web_site[$site['site_id']] = $site;
        }
        Cache::set('web_site', $web_site);
        return $this->success('缓存更新成功！');
    }
}
