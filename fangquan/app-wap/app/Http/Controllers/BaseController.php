<?php

namespace App\Wap\Http\Controllers;

use App\Service\ContentPublish\ContentService;
use App\Service\Developer\DeveloperService;
use App\Service\Provider\ProviderService;

class BaseController extends Controller
{

    const CONST_WEILIAO = 'weiliao';
    const CONST_APP = 'app';
    const CONST_TOUCH = 'touch';
    const CONST_WECHAT = 'wechat';
    const CONST_BROWSER = 'browser';
    const CONST_MOBILE = 'mobile';
    const CONST_DISPATCH_PHONE = 'dispatch_phone';

    const DEVICE_ANDROID = 'android';
    const DEVICE_IPHONE = 'iphone';

    protected $title = '';
    protected $app_title = '';
    protected $meta_title = '';
    protected $meta_keyword = '';
    protected $meta_description = '';
    protected $file_css = '';
    protected $file_js = '';
    protected $log_params;
    protected $page_params;

    protected $is_member_page = true;

    public function __construct()
    {
        //是用户页面
        if ($this->is_member_page) {
        }
    }

    public function setSeo($title, $keyword, $description)
    {
        $this->meta_title = $title;
        $this->meta_keyword = $keyword;
        $this->meta_description = $description;
    }


    protected function view($view, $data = array())
    {
        //开发商数据
        $developer_ids = [1, 2, 3, 4, 5, 6, 7, 8];
        $developer_service = new DeveloperService();
        $developers = $developer_service->getDevelopersByIds($developer_ids);
        $data['developers'] = $developers;

        //供应商数据
        $provider_ids = [269, 139, 488, 80, 489, 490, 457, 341];
        $provider_service = new ProviderService();
        $providers = $provider_service->getProvidersByIds($provider_ids);
        $data['providers'] = $providers;

        $content_service = new ContentService();
        $data['banners'] = $content_service->getContentListByType(19, 5);

        $data = array_merge(
            array(
                'debug'            => config('page.debug'),
                'title'            => $this->title,
                'meta_title'       => $this->meta_title ? $this->meta_title : $this->title,
                'app_title'        => $this->app_title,
                'meta_keyword'     => $this->meta_keyword,
                'meta_description' => $this->meta_description,
                'file_css'         => $this->file_css,
                'file_js'          => $this->file_js,
                'host'             => config('page.host'),
                'base_url'         => config('page.host') . '/js',
                'log_server'       => config('page.server')['log'],
                'uuid'             => '',
                'from_code'        => config('page.from_code'),
                'page_params'      => $this->page_params,
                'city_jianpin'     => 'sh',
                'log_params'       => [
                    'uid'  => '',
                    'guid' => '',
                ],
                'user'             => $this->getUser(),
            ),
            $data
        );
        return view($view, $data);
    }


    /**
     * 得到登录用户
     * @return mixed
     */
    public function getUser()
    {
        $user = request()->user();
        return $user;
    }

}


