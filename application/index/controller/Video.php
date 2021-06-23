<?php
namespace app\index\controller;

use Http\RequestCore;
use think\Controller;

class Video extends Controller
{
    private $headers;
    protected function initialize()
    {
        $this->headers = [
            'Client_Ip: ' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255),
            'X-Forwarded-For: ' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255),
            'X-Requested-With: XMLHttpRequest',
        ];
    }

    public function index()
    {
        return $this->fetch();
    }

    public function parse($link = '')
    {

        $request = new RequestCore();
        $request->set_useragent('Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0');
        foreach ($this->headers as $header) {
            $header = explode(':', $header);
            $request->add_header($header['0'], $header['1']);
        }

        $request->set_request_url('https://api.bbbbbb.me/zy/?url=' . $link);
        $request->send_request();
        $html = $request->get_response_body();
        preg_match('/\"url\":\"(.*?)\",/', $html, $url);
        preg_match('/\"key\":sigu\(\"(.*?)\"\)/', $html, $key);
        $this->view->url = $url;
        $this->view->key = $key;
        return $this->fetch();
    }

    public function x($url = '', $key = '', $type = '')
    {

        $request = new RequestCore();
        $request->set_useragent('Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0');
        foreach ($this->headers as $header) {
            $header = explode(':', $header);
            $request->add_header($header['0'], $header['1']);
        }
        $request->set_method('POST');
        $request->set_request_url('https://api.bbbbbb.me/zy/sigu_jiexi.php');
        $request->set_body([
            'url'  => $url,
            'key'  => $key,
            'type' => $type,
        ]);
        $request->send_request();
        $result = $request->get_response_body();
        $result = json_decode($result, true);
        $request->set_method('GET');
        $request->set_request_url($result['url']);
        $request->set_body([]);
        $request->send_request();
        $html = $request->get_response_body();
        preg_match('/id=\"hdMd5\".*?value=\"(.*?)\"/', $html, $md5);

        return ['id' => $result['url'], 'md5' => $md5['1']];
    }

    public function x2($id = '', $type = 'auto', $siteuser = '', $md5 = '', $hd = '', $lg = '')
    {
        $id = explode('?url=', $id);
        var_dump($id[0] . 'api.php');
        var_dump($id[1]);
        var_dump($md5);
        $request = new RequestCore();
        $request->set_useragent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36');
        $this->headers[] = ':authority: api.bbbbbb.me';
        $this->headers[] = ':method: POST';
        $this->headers[] = ':path: /yunjx3/api.php';
        $this->headers[] = ':scheme: https';
        $this->headers[] = 'accept: application/json, text/javascript, */*; q=0.01';
        $this->headers[] = 'accept-encoding: gzip, deflate, br';
        $this->headers[] = 'accept-language: zh-CN,zh;q=0.9';
        $this->headers[] = 'content-length: 121';
        $this->headers[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
        $this->headers[] = 'cookie: pgv_pvi=977140736; Hm_lvt_edc193f077b6b613964bcf4bbf0712d2=1550301290,1550301503,1550301567,1550302281; Hm_lpvt_edc193f077b6b613964bcf4bbf0712d2=1550309444';
        $this->headers[] = 'origin: https://api.bbbbbb.me';
        $this->headers[] = 'referer: https://api.bbbbbb.me/yunjx3/?url=http://v.pptv.com/show/QzdZ1j6kFFK1M5s.html';
        $this->headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36';
        $this->headers[] = 'x-requested-with: XMLHttpRequest';
        foreach ($this->headers as $header) {
            $header = explode(':', $header);
            $request->add_header($header['0'], $header['1']);
        }
        $request->set_method('POST');
        $request->set_request_url($id[0] . 'api.php');
        $request->set_body([
            'id'       => 'http://v.pptv.com/show/QzdZ1j6kFFK1M5s.html',
            'type'     => 'auto',
            'siteuser' => '',
            'md5'      => 'ab599b61248ab5d61c7768871375loij',
            'hd'       => '',
            'lg'       => '',
        ]);
        $request->send_request();
        $result = $request->get_response_body();
        var_dump($result);
    }
}
