<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\common\model\Jobs;

class Queue extends Base
{
    public function index()
    {
        $where                  = [];
        $this->view->queue_list = Jobs::where($where)->paginate(10);
        $this->view->page       = $this->view->queue_list->render();
        return $this->fetch();
    }

    public function create()
    {
        if ($this->request->isPost()) {
            $result = $this->validate($this->request->post(), [
                'title'   => 'require',
                'queue'   => 'require',
                'payload' => 'require',
            ], [
                'title'   => '用户名必填',
                'queue'   => '队列名必填，默认default',
                'payload' => '执行文件名必填',
            ]);
            if ($result !== true) {
                return $this->error($result);
            }
            Jobs::create($this->request->post());
            return $this->success('任务添加成功');
        }
        return $this->fetch();
    }

    public function edit($id = 0)
    {
        $job = Jobs::where('id', '=', $id)->find();
        if (empty($job)) {
            return $this->error('指定数据不存在');
        }
        if ($this->request->isPost()) {
            $result = $this->validate($this->request->post(), [
                'title'   => 'require',
                'queue'   => 'require',
                'payload' => 'require',
            ], [
                'title'   => '用户名必填',
                'queue'   => '队列名必填，默认default',
                'payload' => '执行文件名必填',
            ]);
            if ($result !== true) {
                return $this->error($result);
            }
            $job->allowField(true)->save($this->request->post(), ['id' => $job['id']]);
            return $this->success('任务数据编辑成功！');
        }
        $this->view->job = $job;
        return $this->fetch();
    }

    public function delete($id = 0)
    {
        if (!$this->request->isAjax()) {
            return $this->error('请求类型错误');
        }
        $job = Jobs::where('id', '=', $id)->find();
        if (empty($job)) {
            return $this->error('指定数据不存在');
        }
        $job->delete();
        return $this->success('任务删除成功');
    }
}
