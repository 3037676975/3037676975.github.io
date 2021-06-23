<?php
namespace app\common\model;

use app\common\model\Attach;
use app\common\model\HttpCurl;
use think\facade\Debug;
use think\facade\Request;

class ParseUrl
{
    private $link;
    private $site;
    private $cookie;

    public function __construct($link, $site, $cookie)
    {
        $this->link   = $link;
        $this->site   = $site;
        $this->cookie = $cookie;
    }

    private function get_cache($site_code = '', $site_code_type = '')
    {
        $query = Attach::where('site_id', $this->site['site_id'])->where('site_code_type', $site_code_type)->where('site_code', $site_code)->where('status', '>', 0)->select();
        if (!$query->isEmpty()) {
            $download = [];
            foreach ($query as $attach) {
                $download[$attach['button_name']] = url('index/download/index', ['attach_id' => $attach['attach_id']]);
            }
            if (!empty($download)) {
                return ['code' => 1, 'has_attach' => 1, 'msg' => $download];
            }
        }
        return false;
    }

    public function get_51yuansu_com()
    {
        preg_match('/\/(\w+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
        $header = [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'www.51yuansu.com',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
        ];
        $http_curl = new HttpCurl($this->link, 'GET', null, $header, true);
        $html      = $http_curl->send_request()->get_response_body();

        $header['Accept']           = 'application/json, text/javascript, */*; q=0.01';
        $header['Referer']          = $this->link;
        $header['X-Requested-With'] = 'XMLHttpRequest';
        $download                   = [];
        if (preg_match('/data-id="' . $site_code['1'] . '".*?class="p-down-operate /', $html) > 0) {
            $http_curl = new HttpCurl('http://www.51yuansu.com/index.php?m=ajax&a=down&id=' . $site_code['1'], 'GET', null, $header, true);
            $response  = $http_curl->send_request()->get_response_body();
            $response  = json_decode($response, true);
            if (!empty($response['url'])) {
                $download['PNG下载'] = $response['url'];
            }
        }
        if (preg_match('/data-id="' . $site_code['1'] . '".*?class="p-down-operate-zip /', $html) > 0) {
            $http_curl = new HttpCurl('http://www.51yuansu.com/index.php?m=ajax&a=downPsd&id=' . $site_code['1'], 'GET', null, $header, true);
            $response  = $http_curl->send_request()->get_response_body();
            $response  = json_decode($response, true);
            if (!empty($response['url'])) {
                $download['PSD下载'] = $response['url'];
            }
        }
        if (preg_match('/data-id="' . $site_code['1'] . '".*?class="b-down-operate-zip /', $html) > 0) {
            $http_curl = new HttpCurl('http://www.51yuansu.com/index.php?m=ajax&a=bdownPsd&id=' . $site_code['1'], 'GET', null, $header, true);
            $response  = $http_curl->send_request()->get_response_body();
            $response  = json_decode($response, true);
            if (!empty($response['url'])) {
                $download['背景PSD下载'] = $response['url'];
            }
        }
        if (preg_match('/data-id="' . $site_code['1'] . '".*?class="b-down-operate /', $html) > 0) {
            $http_curl = new HttpCurl('http://www.51yuansu.com/index.php?m=ajax&a=bdown&id=' . $site_code['1'], 'GET', null, $header, true);
            $response  = $http_curl->send_request()->get_response_body();
            $response  = json_decode($response, true);
            if (!empty($response['url'])) {
                $download['背景JPG下载'] = $response['url'];
            }
        }
        if (!empty($download)) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => $download];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_ooopic_com()
    {
        preg_match('/\/pic_([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
        $header = [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate, br',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Cache-Control'             => 'max-age=0',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'www.ooopic.com',
            'Referer'                   => 'https://www.ooopic.com/home-80-422---.html',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
        ];
        $http_curl = new HttpCurl('https://downloads.ooopic.com/down_newfreevip.php?id=' . $site_code['1'], 'GET', null, $header, true);
        $html      = $http_curl->send_request()->get_response_body();

        $html = iconv('GBK', 'UTF-8', $html);
        preg_match('/name=\"token\".*?value=\"(.*?)\"/', $html, $match);
        if (empty($match['1'])) {
            return ['code' => 0, 'msg' => '资源解析失败，请联系管理员'];
        }

        $http_curl       = new HttpCurl('https://downloads.ooopic.com/down_newfreevip.php?action=down&id=' . $site_code['1'] . '&token=' . $match['1'], 'GET', null, $header, true);
        $response_header = $http_curl->request_curlopts([
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_MAXREDIRS      => 0,
        ])->send_request()->get_response_header();
        if (!empty($response_header['location'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $response_header['location']]];
        } else if (!empty($response_header['info']['redirect_url'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $response_header['info']['redirect_url']]];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_58pic_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
        $header = [

            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate, br',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Cache-Control'             => 'max-age=0',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'dl.58pic.com',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
        ];
        $http_curl = new HttpCurl('https://dl.58pic.com/' . $site_code['1'] . '.html', 'GET', null, $header, true);
        $html      = $http_curl->send_request()->get_response_body();
        $html      = iconv('gbk', 'utf-8', $html);
        preg_match('/attr-type=\"a1\".*?href=\"(.*?)\"/', $html, $href);

        if (!empty($href['1'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $href['1']]];
        } else {
            preg_match('/<a href=\"(.*?)\" class=\"text-green\" one-site>/', $html, $href);
            if (!empty($href['1'])) {
                return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $href['1']]];
            }
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_90sheji_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
        $header = [
            'Accept'           => 'application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding'  => 'gzip, deflate',
            'Accept-Language'  => 'zh-CN,zh;q=0.9',
            'Connection'       => 'keep-alive',
            'Content-Length'   => strlen('id=' . $site_code['1']),
            'Content-Type'     => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Cookie'           => '' . $this->cookie,
            'Host'             => '90sheji.com',
            'Origin'           => 'http://90sheji.com',
            'Referer'          => 'http://90sheji.com/?m=Inspire&a=download&id=' . $site_code['1'],
            'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
            'X-Requested-With' => 'XMLHttpRequest',
        ];
        $http_curl = new HttpCurl('http://90sheji.com/index.php?m=inspireAjax&a=getDownloadLink', 'POST', 'id=' . $site_code['1'], $header, true);
        $result    = $http_curl->send_request()->get_response_body();
        $result    = json_decode($result, 1);
        if (!empty($result['link'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $result['link']]];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_588ku_com()
    {
        $site_code = [];
        $url_type  = '';
        //免扣元素 背景图库 设计模板 摄影图库 艺术字 UI设计 商用插画 办公文档 视频 字体库
        foreach (['ycpng', 'ycbeijing', 'moban', 'sheyingtu', 'ycwordart', 'uiweb', 'ichahua', 'office', 'video', 'font', 'ycaudio'] as $type) {
            preg_match('/' . $type . '\/([0-9]+).html/', $this->link, $match);
            if (!empty($match[1])) {
                $url_type  = $type;
                $site_code = $match;
                break;
            }
        }
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1'], $url_type);
        if ($cache !== false) {
            return $cache;
        }
        $header = [
            'Accept'           => 'application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding'  => 'gzip, deflate',
            'Accept-Language'  => 'zh-CN,zh;q=0.9',
            'Connection'       => 'keep-alive',
            'Cookie'           => $this->cookie,
            'Host'             => '588ku.com',
            'Referer'          => $this->link,
            'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
            'X-Requested-With' => 'XMLHttpRequest',
        ];
        $header2 = [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Cache-Control'             => 'max-age=0',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'dl.588ku.com',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
        ];
        $download = [];
        switch ($url_type) {
            case 'ycpng':
                //PNG
                $curl   = new HttpCurl('http://588ku.com/?m=element&a=down&id=' . $site_code['1'], 'GET', null, $header, true);
                $result = $curl->send_request()->get_response_body();
                $result = json_decode($result, true);
                if (!empty($result['url'])) {
                    $download['下载PNG'] = $result['url'];
                }
                //PSD
                $curl   = new HttpCurl('http://588ku.com/?m=element&a=downpsd&id=' . $site_code['1'], 'GET', null, $header, true);
                $result = $curl->send_request()->get_response_body();
                $result = json_decode($result, true);
                if (!empty($result['url'])) {
                    $download['下载源文件'] = $result['url'];
                }
                break;
            case 'ycbeijing':
                //JPG
                $curl   = new HttpCurl('http://588ku.com/?m=back&a=down&id=' . $site_code['1'], 'GET', null, $header, true);
                $result = $curl->send_request()->get_response_body();
                $result = json_decode($result, true);
                if (!empty($result['url'])) {
                    $download['下载JPG'] = $result['url'];
                }
                //PSD
                $curl   = new HttpCurl('http://588ku.com/?m=back&a=downpsd&id=' . $site_code['1'], 'GET', null, $header, true);
                $result = $curl->send_request()->get_response_body();
                $result = json_decode($result, true);
                if (!empty($result['url'])) {
                    $download['下载源文件'] = $result['url'];
                }
                break;
            case 'moban':
                //PNG
                $curl   = new HttpCurl('http://dl.588ku.com/down/pic?callback=handleResponse&type=3&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载JPG'] = $result['data']['url'];
                }

                //源文件
                $curl   = new HttpCurl('http://dl.588ku.com/down/rar?callback=handleResponse&type=3&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载源文件'] = $result['data']['url'];
                }
                break;
            case 'sheyingtu':

                $curl   = new HttpCurl('http://dl.588ku.com/down/pic?callback=handleResponse&type=10&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载JPG'] = $result['data']['url'];
                }
                break;
            case 'ycwordart':
                //PNG
                $curl   = new HttpCurl('http://dl.588ku.com/down/pic?callback=handleResponse&type=6&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载JPG'] = $result['data']['url'];
                }

                //源文件
                $curl   = new HttpCurl('http://dl.588ku.com/down/rar?callback=handleResponse&type=6&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载源文件'] = $result['data']['url'];
                }
                break;
            case 'uiweb':

                //源文件
                $curl   = new HttpCurl('http://dl.588ku.com/down/rar?callback=handleResponse&type=9&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载源文件'] = $result['data']['url'];
                }
                break;
            case 'ichahua':
                //PNG
                $curl   = new HttpCurl('http://dl.588ku.com/down/pic?callback=handleResponse&type=7&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载JPG'] = $result['data']['url'];
                }

                //源文件
                $curl   = new HttpCurl('http://dl.588ku.com/down/rar?callback=handleResponse&type=7&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载源文件'] = $result['data']['url'];
                }
                break;
            case 'office':
                //源文件
                $curl   = new HttpCurl('http://dl.588ku.com/down/rar?callback=handleResponse&type=4&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载源文件'] = $result['data']['url'];
                }
                break;
            case 'video':
                //源文件
                $curl   = new HttpCurl('http://dl.588ku.com/down/rar?callback=handleResponse&type=5&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                    $download['下载源文件'] = $result['data']['url'];
                }
                break;
            case 'ycaudio':
                //源文件
                $curl   = new HttpCurl('http://dl.588ku.com/down/rar?callback=handleResponse&type=8&picid=' . $site_code['1'], 'GET', null, $header2, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);

                $http_curl       = new HttpCurl($result['data']['url'], 'GET', null, $header2, true);
                $response_header = $http_curl->request_curlopts([
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_MAXREDIRS      => 0,
                ])->send_request()->get_response_header();
                if (!empty($response_header['location'])) {
                    $download['下载源文件'] = $response_header['location'];
                } else if (!empty($response_header['info']['redirect_url'])) {
                    $download['下载源文件'] = $response_header['info']['redirect_url'];
                }

                break;
            case 'font':
                //源文件
                /*   $curl   = new HttpCurl('http://dl.588ku.com/down/rar?callback=handleResponse&type=5&picid=' . $site_code['1'], 'GET', null, $header, true);
                $result = str_replace(['handleResponse(', ');'], '', $curl->send_request()->get_response_body());
                $result = json_decode($result, true);
                if (!empty($result['data']['url'])) {
                $download['下载源文件'] = $result['data']['url'];
                }*/
                break;
        }

        if (!empty($download)) {
            return ['code' => 1, 'site_code_type' => $url_type, 'site_code' => $site_code['1'], 'msg' => $download];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_ibaotu_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
        $header = [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate, br',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Cache-Control'             => 'max-age=0',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'ibaotu.com',
            'Referer'                   => $this->link,
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
        ];
        $curl = new HttpCurl('https://ibaotu.com/?m=download&id=' . $site_code['1'], 'GET', null, $header, true);
        $html = $curl->send_request()->get_response_body();
        preg_match('/<a href="(.*?)" id="downvip".*?>.*?VIP免费下载.*?<\/a>/', $html, $url);
        if (empty($url['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $curl            = new HttpCurl('https:' . $url['1'], 'GET', null, $header, true);
        $response_header = $curl->request_curlopts([
            CURLOPT_NOBODY         => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_RETURNTRANSFER => true,
        ])->send_request()->get_response_header();
        if (!empty($response_header['info']['url'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $response_header['info']['url']]];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_699pic_com()
    {
        preg_match('/\/video-([0-9]+).html/', $this->link, $site_code); //视频
        if (!empty($site_code['1'])) {
            $cache = $this->get_cache($site_code['1'], 'video');
            if ($cache !== false) {
                return $cache;
            }
            $header = [
                'Accept'           => 'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding'  => 'gzip, deflate',
                'Accept-Language'  => 'zh-CN,zh;q=0.9',
                'Connection'       => 'keep-alive',
                'Cookie'           => $this->cookie,
                'Host'             => '699pic.com',
                'Referer'          => $this->link,
                'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
                'X-Requested-With' => 'XMLHttpRequest',
            ];

            $curl   = new HttpCurl('http://699pic.com/download/video?id=' . $site_code['1'], 'GET', null, $header, true);
            $result = $curl->send_request()->get_response_body();
            $result = json_decode($result, true);
            if (!empty($result['src'])) {
                return ['code' => 1, 'site_code_type' => 'video', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $result['src']]];
            }
        }
        preg_match('/\/font-([0-9]+).html/', $this->link, $site_code); //字体
        if (!empty($site_code['1'])) {
            $cache = $this->get_cache($site_code['1'], 'font');
            if ($cache !== false) {
                return $cache;
            }
            $post_data = 'fid=' . $site_code['1'] . '&download_from=0&sid=0&page_num=0';
            $header    = [
                'Accept'           => '*/*',
                'Accept-Encoding'  => 'gzip, deflate',
                'Accept-Language'  => 'zh-CN,zh;q=0.9',
                'Connection'       => 'keep-alive',
                'Content-Length'   => strlen($post_data),
                'Content-Type'     => 'application/x-www-form-urlencoded',
                'Cookie'           => $this->cookie,
                'Host'             => '699pic.com',
                'Origin'           => 'http://699pic.com',
                'Referer'          => $this->link,
                'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
                'X-Requested-With' => 'XMLHttpRequest',
            ];

            $curl   = new HttpCurl('http://699pic.com/newdownload/font', 'POST', $post_data, $header, true);
            $result = $curl->send_request()->get_response_body();
            $result = json_decode($result, true);
            if (!empty($result['url'])) {
                return ['code' => 1, 'site_code_type' => 'font', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $result['url']]];
            }
        }
        preg_match('/\/tupian-([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $header = [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Cache-Control'             => 'max-age=0',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => '699pic.com',
            'Referer'                   => $this->link,
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
        ];
        $curl = new HttpCurl($this->link, 'GET', null, $header, true);
        $html = $curl->send_request()->get_response_body();
        preg_match('/CONFIG\[\'search_mode\'\] = \'(.*?)\';/', $html, $match);

        preg_match('/<input type="hidden" value="(.*?)" id="byso".*?/', $html, $byso);
        preg_match('/<input type="hidden" value="(.*?)" id="bycat".*?/', $html, $bycat);
        $download = [];
        if (!empty($match['1'])) {
            $cache = $this->get_cache($site_code['1'], $match['1']);
            if ($cache !== false) {
                return $cache;
            }
            $header = [
                'Accept'           => '*/*',
                'Accept-Encoding'  => 'gzip, deflate',
                'Accept-Language'  => 'zh-CN,zh;q=0.9',
                'Connection'       => 'keep-alive',
                'Content-Length'   => '28',
                'Content-Type'     => 'application/x-www-form-urlencoded',
                'Cookie'           => $this->cookie,
                'Host'             => '699pic.com',
                'Origin'           => 'http://699pic.com',
                'Referer'          => $this->link,
                'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
                'X-Requested-With' => 'XMLHttpRequest',
            ];

            switch ($match['1']) {
                case 'photo':
                    $ajax_url = 'http://699pic.com/download/getDownloadUrl';
                    break;
                case 'vector':
                    $ajax_url = 'http://699pic.com/newdownload/design';
                    break;
                case 'originality':
                    $ajax_url = 'http://699pic.com/download/getDownloadUrl';
                    break;
                case 'chahua':
                    $ajax_url = 'http://699pic.com/download/getDownloadUrl';
                    break;
                case 'yuansu':
                    $ajax_url = 'http://699pic.com/newdownload/yuansu';
                    break;
                case 'peitu':
                    $ajax_url = 'http://699pic.com/newdownload/phoneMap';
                    break;
                case 'gif':
                    $ajax_url = 'http://699pic.com/download/getDownloadUrl';
                    break;
                case 'ppt':
                    $ajax_url = 'http://699pic.com/download/getDownloadUrl';

                    $curl   = new HttpCurl($ajax_url, 'POST', 'pid=' . $site_code['1'] . '&byso=' . (isset($byso['1']) ? $byso['1'] : 0) . '&bycat=' . (isset($bycat['1']) ? $bycat['1'] : 0), $header, true);
                    $result = $curl->send_request()->get_response_body();
                    $result = json_decode($result, true);
                    if (!empty($result['url'])) {
                        return ['code' => 1, 'site_code_type' => 'ppt', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $result['url']]];
                    }
                    break;
            }
            preg_match_all('/<i class="i-set.*?" data-id=[\'|"](.*?)[\'|"]>/', $html, $ids);
            if (empty($ids['1']) || count($ids['1']) <= 0 || empty($ids['1'][0])) {
                return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
            }
            foreach ($ids['1'] as $filetype) {
                $curl   = new HttpCurl($ajax_url, 'POST', 'pid=' . $site_code['1'] . '&byso=' . (isset($byso['1']) ? $byso['1'] : 0) . '&bycat=' . (isset($bycat['1']) ? $bycat['1'] : 0) . '&filetype=' . $filetype, $header, true);
                $result = $curl->send_request()->get_response_body();
                $result = json_decode($result, true);
                if (!empty($result['url'])) {
                    $download['下载文件_' . $filetype] = $result['url'];
                }
            }
        }

        if (!empty($download)) {
            return ['code' => 1, 'site_code_type' => isset($match['1']) ? $match['1'] : '', 'site_code' => $site_code['1'], 'msg' => $download];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_download_csdn_net()
    {
        preg_match('/download\/.*?\/([0-9]+)/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_docer_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }

        $header = [
            'Accept'           => 'application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding'  => 'gzip, deflate',
            'Accept-Language'  => 'zh-CN,zh;q=0.9',
            'Connection'       => 'keep-alive',
            'Cookie'           => $this->cookie,
            'Host'             => 'detail.docer.com',
            'Referer'          => $this->link,
            'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
            'X-Requested-With' => 'XMLHttpRequest',
        ];
        $http_curl = new HttpCurl('http://detail.docer.com/detail/dl?id=' . $site_code['1'], 'GET', null, $header, true);
        $result    = $http_curl->send_request()->get_response_body();
        $result    = json_decode($result, 1);
        if (!empty($result['data'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $result['data']]];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_wenku_baidu_com()
    {
        preg_match('/view\/(\w+)/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }

        $header = [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate, br',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Cache-Control'             => 'max-age=0',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'wenku.baidu.com',
            'Referer'                   => 'https://wenku.baidu.com/user/mydownload',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
        ];
        $http_curl = new HttpCurl($this->link, 'GET', null, $header, true);
        $html      = $http_curl->send_request()->get_response_body();
        $html      = iconv('GBK', 'UTF-8', $html);
        preg_match('/<form name="downloadForm".*?>(.*?)<\/form>/s', $html, $form);
        if (count($form) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"ct\".*?value=\"(.*?)\"/', $form['1'], $ct);
        if (count($ct) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"retType\".*?value=\"(.*?)\"/', $form['1'], $retType);
        if (count($retType) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"storage\".*?value=\"(.*?)\"/', $form['1'], $storage);
        if (count($storage) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"useTicket\".*?value=\"(.*?)\"/', $form['1'], $useTicket);
        if (count($useTicket) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"target_uticket_num\".*?value=\"(.*?)\"/', $form['1'], $target_uticket_num);
        if (count($target_uticket_num) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"downloadToken\".*?value=\"(.*?)\"/', $form['1'], $downloadToken);
        if (count($downloadToken) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"sz\".*?value=\"(.*?)\"/', $form['1'], $sz);
        if (count($sz) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"v_code\".*?value=\"(.*?)\"/', $form['1'], $v_code);
        if (count($v_code) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"v_input\".*?value=\"(.*?)\"/', $form['1'], $v_input);
        if (count($v_input) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/name=\"req_vip_free_doc\".*?value=\"(.*?)\"/', $form['1'], $req_vip_free_doc);
        if (count($req_vip_free_doc) < 2) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        $postfields = [
            'ct'                 => $ct['1'],
            'doc_id'             => $site_code['1'],
            'retType'            => $retType['1'],
            'sns_type'           => '',
            'storage'            => $storage['1'],
            'useTicket'          => $useTicket['1'],
            'target_uticket_num' => $target_uticket_num['1'],
            'downloadToken'      => $downloadToken['1'],
            'sz'                 => $sz['1'],
            'v_code'             => $v_code['1'],
            'v_input'            => $v_input['1'],
            'req_vip_free_doc'   => $req_vip_free_doc['1'],
        ];
        $http_curl = new HttpCurl('https://wenku.baidu.com/user/submit/download', 'POST', http_build_query($postfields), [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate, br',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Cache-Control'             => 'max-age=0',
            'Connection'                => 'keep-alive',
            'Content-Length'            => '207',
            'Content-Type'              => 'application/x-www-form-urlencoded',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'wenku.baidu.com',
            'Origin'                    => 'https://wenku.baidu.com',
            'Referer'                   => $this->link,
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
        ], true);
        $response_header = $http_curl->request_curlopts([
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_MAXREDIRS      => 0,
            CURLOPT_ENCODING       => 'gzip',
        ])->send_request()->get_response_header();
        if (empty($response_header['location'])) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        preg_match('/filename=\"(.*?)\"/', urldecode(urldecode($response_header['location'])), $filename);
        if (!isset($filename['1'])) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }

        $attach = Attach::create([
            'site_id'      => $this->site['site_id'],
            'request_url'  => $this->link,
            'site_code'    => $site_code['1'],
            'filename'     => $filename['1'],
            'response_url' => $response_header['location'],
            'button_name'  => '立即下载',
            'queue_error'  => '',
            'status'       => 0,
        ]);
        Debug::remark('begin');
        $request = new \Http\RequestCore($attach->response_url);

        $request->set_write_file($attach->local_file);
        try {
            $request->send_request();
        } catch (\Exception $e) {
            $attach->queue_error = $e->getMessage();
            $attach->save();
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }

        Debug::remark('end');
        $attach->queue_error   = '';
        $attach->download_time = Debug::getRangeTime('begin', 'end');
        if (!is_file($attach->local_file)) {
            return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
        }
        $attach->savename = md5(request()->time() . random(10)) . '.' . pathinfo($filename['1'], PATHINFO_EXTENSION);
        $attach->filesize = filesize($attach->local_file);
        $attach->status   = 2;
        $attach->save();
        return ['code' => 1, 'site_code_type' => '', 'has_attach' => 1, 'site_code' => $site_code['1'], 'msg' => ['立即下载' => url('index/download/index', ['attach_id' => $attach['attach_id']])]];

    }

    public function get_17sucai_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }

        $header = [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Cache-Control'             => 'max-age=0',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'www.17sucai.com',
            'Referer'                   => 'http://www.17sucai.com/',
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
        ];
        $http_curl = new HttpCurl($this->link, 'GET', null, $header, true);
        $html      = $http_curl->send_request()->get_response_body();
        preg_match('/<div class="left btn-download">(.*?)<\/div>/s', $html, $match);
        if (!empty($match[1])) {
            preg_match('/href="(.*?)"/', $match[1], $href);
            if (!empty($href[1])) {
                $attach = Attach::create([
                    'site_id'      => $this->site['site_id'],
                    'request_url'  => $this->link,
                    'site_code'    => $site_code['1'],
                    'filename'     => $site_code['1'] . '.zip',
                    'response_url' => $href[1],
                    'button_name'  => '立即下载',
                    'queue_error'  => '',
                    'status'       => 1,
                ]);
                Debug::remark('begin');

                $headerx = [];
                foreach ($header as $key => $value) {
                    $headerx[] = $key . ': ' . $value;
                }

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_TIMEOUT, 3600);
                curl_setopt($curl, CURLOPT_URL, $href[1]);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headerx);
                curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $response    = curl_exec($curl);
                $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                $fp          = fopen($attach->local_file, 'w+');
                fwrite($fp, substr($response, $header_size));
                fclose($fp);

                $response_headers = substr($response, 0, $header_size);
                $response_headers = explode("\r\n\r\n", trim($response_headers));
                $response_headers = array_pop($response_headers);
                $response_headers = explode("\r\n", $response_headers);
                array_shift($response_headers);
                $header_assoc = [];
                foreach ($response_headers as $header) {
                    $kv                               = explode(': ', $header);
                    $header_assoc[strtolower($kv[0])] = isset($kv[1]) ? $kv[1] : '';
                }
                if (!empty($header_assoc['content-disposition'])) {
                    preg_match('/filename=\"(.*?)\"/', $header_assoc['content-disposition'], $disposition);
                    if (!empty($disposition['1'])) {
                        $attach->filename = $disposition['1'];
                        $attach->savename = md5(request()->time() . random(10)) . '.' . pathinfo($disposition['1'], PATHINFO_EXTENSION);
                    }
                }
                curl_close($curl);
                Debug::remark('end');

                $attach->download_time = Debug::getRangeTime('begin', 'end');
                if (!is_file($attach->local_file)) {
                    return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
                }

                $ext = $this->get_ext($attach->local_file);
                if ($ext !== 'unknow') {
                    $attach->savename = md5(request()->time() . random(10)) . '.' . $ext;
                }
                $attach->filesize = filesize($attach->local_file);
                $attach->status   = 2;
                $attach->save();
                return ['code' => 1, 'site_code_type' => '', 'has_attach' => 1, 'site_code' => $site_code['1'], 'msg' => ['立即下载' => url('index/download/index', ['attach_id' => $attach['attach_id']])]];
            }
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_tukuppt_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
    }

    public function get_92sucai_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
    }

    public function get_yanj_cn()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
    }

    public function get_pic_netbian_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
    }

    public function get_huiyi8_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
    }

    public function get_88tph_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }

        $header = [
            'Accept'           => 'application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding'  => 'gzip, deflate, br',
            'Accept-Language'  => 'zh-CN,zh;q=0.9',
            'Connection'       => 'keep-alive',
            'Content-Length'   => '21',
            'Content-Type'     => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Cookie'           => $this->cookie,
            'Host'             => 'www.88tph.com',
            'Origin'           => 'https://www.88tph.com',
            'Referer'          => $this->link,
            'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
            'X-Requested-With' => 'XMLHttpRequest',
        ];
        $http_curl = new HttpCurl('https://www.88tph.com/geturl', 'POST', 'doc=' . $site_code['1'] . '&vip=true', $header, true);
        $result    = $http_curl->send_request()->get_response_body();
        $result    = json_decode($result, 1);
        if (!empty($result['body']['url'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $result['body']['url']]];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_51miz_com()
    {
        preg_match('/\/([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }

        $download = [];
        $header   = [
            'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'Accept-Encoding'           => 'gzip, deflate',
            'Accept-Language'           => 'zh-CN,zh;q=0.9',
            'Connection'                => 'keep-alive',
            'Cookie'                    => $this->cookie,
            'Host'                      => 'www.51miz.com',
            'Referer'                   => $this->link,
            'Upgrade-Insecure-Requests' => '1',
            'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
        ];
        $http_curl       = new HttpCurl('http://www.51miz.com/?m=download&a=download&id=' . $site_code['1'] . '&plate_id=17&format=source', 'GET', null, $header, true);
        $response_header = $http_curl->request_curlopts([
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_MAXREDIRS      => 0,
        ])->send_request()->get_response_header();

        if (!empty($response_header['location'])) {
            $download['下载PSD'] = $response_header['location'];
        }
        $http_curl       = new HttpCurl('http://www.51miz.com/?m=download&a=download&id=' . $site_code['1'] . '&plate_id=17&format=image', 'GET', null, $header, true);
        $response_header = $http_curl->request_curlopts([
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_MAXREDIRS      => 0,
        ])->send_request()->get_response_header();

        if (!empty($response_header['location'])) {
            $download['下载PNG'] = $response_header['location'];
        }
        if (!empty($download)) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => $download];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_16pic_com()
    {
        preg_match('/\/pic_([0-9]+).html/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }

        $header = [
            ':authority'       => 'www.16pic.com',
            ':method'          => 'GET',
            ':path'            => '/down/down?id=' . $site_code['1'] . '&from=1',
            ':scheme'          => 'https',
            'accept'           => 'application/json, text/javascript, */*; q=0.01',
            'accept-encoding'  => 'gzip, deflate, br',
            'accept-language'  => 'zh-CN,zh;q=0.9',
            'cookie'           => $this->cookie,
            'referer'          => $this->link,
            'user-agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
            'x-requested-with' => 'XMLHttpRequest',
        ];
        $http_curl = new HttpCurl('https://www.16pic.com/down/down?id=' . $site_code['1'] . '&from=1', 'GET', null, $header, true);
        $result    = $http_curl->send_request()->get_response_body();
        $result    = json_decode($result, 1);
        if (!empty($result['res_data'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $result['res_data']]];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    public function get_125pic_com()
    {
        preg_match('/\/([0-9]+)/', $this->link, $site_code);
        if (empty($site_code['1'])) {
            return ['code' => 0, 'msg' => '解析失败，网址输入错误或不支持该站点解析'];
        }
        $cache = $this->get_cache($site_code['1']);
        if ($cache !== false) {
            return $cache;
        }
        $header = [
            'Accept'           => 'application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding'  => 'gzip, deflate',
            'Accept-Language'  => 'zh-CN,zh;q=0.9',
            'Connection'       => 'keep-alive',
            'Content-Length'   => '31',
            'Content-Type'     => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Cookie'           => $this->cookie,
            'Host'             => 'www.125pic.com',
            'Origin'           => 'http://www.125pic.com',
            'Referer'          => $this->link,
            'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36',
            'X-Requested-With' => 'XMLHttpRequest',
        ];
        $http_curl = new HttpCurl('http://www.125pic.com/api/sucai/download', 'POST', '{"id":' . $site_code['1'] . ',"t":' . Request::time() . random(3, 1) . '}', $header, true);
        $result    = $http_curl->send_request()->get_response_body();
        $result    = json_decode($result, 1);
        if (!empty($result['data']['url'])) {
            return ['code' => 1, 'site_code_type' => '', 'site_code' => $site_code['1'], 'msg' => ['立即下载' => $result['data']['url']]];
        }
        return ['code' => 0, 'msg' => '解析失败，请联系管理员'];
    }

    private function get_ext($local_file = '', $filename = '')
    {
        $file = fopen($local_file, 'rb');
        $bin  = fread($file, 2);
        fclose($file);
        $strInfo  = @unpack('C2chars', $bin);
        $typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);
        switch ($typeCode) {
            case 7790:
                $fileType = 'exe';
                break;
            case 7784:
                $fileType = 'midi';
                break;
            case 8297:
                $fileType = 'rar';
                break;
            case 255216:
                $fileType = 'jpg';
                break;
            case 7173:
                $fileType = 'gif';
                break;
            case 6677:
                $fileType = 'bmp';
                break;
            case 13780:
                $fileType = 'png';
                break;
            case 8075:
                $fileType = 'zip';
                break;
            case 4949:
                $fileType = 'tar';
                break;
            case 55122:
                $fileType = '7z';
                break;
            case 5666:
                $fileType = 'psd';
                break;
            default:
                if (empty($filename)) {
                    $fileType = 'unknow';
                } else {
                    $fileType = pathinfo($filename, PATHINFO_EXTENSION);
                }
        }
        return $fileType;
    }
}
