<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Db;

class Index extends Base
{

    public function index()
    {
        global $_G;

        $version                   = Db::query('SELECT version() as ver');
        $this->view->mysql_version = $version[0]['ver'];

        $sql = "SHOW TABLE STATUS FROM " . config('database.database');
        if ($prefix = config('database.prefix')) {
            $sql .= " LIKE '{$prefix}%'";
        }
        $row  = Db::query($sql);
        $size = 0;
        foreach ($row as $value) {
            $size += $value['Data_length'] + $value['Index_length'];
        }
        $this->view->db_size = format_bytes($size);
        return $this->fetch();
    }
}
