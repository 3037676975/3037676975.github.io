<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\common\model\Setting as CommonSetting;

class Setting extends Base
{
    public function index()
    {
        if ($this->request->isPost()) {
            foreach ($this->request->post('setting/a') as $key => $value) {
                CommonSetting::where('key', '=', $key)->update(['value' => $value]);
            }
            return $this->success('设置保存成功！');
        }
        return $this->fetch();
    }
}
