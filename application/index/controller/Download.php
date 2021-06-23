<?php
namespace app\index\controller;

use app\common\model\Attach;
use OSS\OssClient;
use think\Controller;

class Download extends Controller
{

    public function index($attach_id = 0)
    {
        global $_G;
        $attach = Attach::where('attach_id', '=', $attach_id)->find();
        if (!$attach || $attach['status'] < 2) {
            return $this->error('文件不存在');
        }
        if ($_G['setting']['AccessKeyId'] && $_G['setting']['AccessKeySecret'] && $_G['setting']['Endpoint']) {
            $ossClient = new OssClient($_G['setting']['AccessKeyId'], $_G['setting']['AccessKeySecret'], $_G['setting']['Endpoint']);
            if ($_G['setting']['Bucket']) {
                $doesExist = $ossClient->doesObjectExist($_G['setting']['Bucket'], $attach['savename']) ? 'setting' : '';
            }
            if (empty($doesExist) && !empty($attach['bucket'])) {
                $doesExist = $ossClient->doesObjectExist($attach['bucket'], $attach['savename']) ? 'attach' : '';
            }
        }

        ob_end_clean();
        header("Content-type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");
        header("Accept-Ranges: bytes");
        header("Content-Length: " . $attach['filesize']);
        header("Content-Disposition: attachment; filename=\"" . ($attach['filename'] ?: $attach['savename']) . "\"");
        if (is_file($attach['local_file'])) {
            $file = fopen($attach['local_file'], 'rb');
            while (!feof($file)) {
                echo fread($file, 102400);
            }
            fclose($file);
            exit;
        } else if ($doesExist) {
            $start_range = 0;
            while ($start_range < $attach['filesize']) {
                $end_range = $start_range + 102400;
                $end_range = $end_range >= $attach['filesize'] ? $attach['filesize'] - 1 : $end_range;
                echo $ossClient->getObject($doesExist == 'setting' ? $_G['setting']['Bucket'] : 'attach', $attach['savename'], [
                    'range' => $start_range . '-' . $end_range,
                ]);
                $start_range = $end_range + 1;
            }
            exit;
        }
    }
}
