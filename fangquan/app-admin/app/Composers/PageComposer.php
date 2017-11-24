<?php

namespace App\Admin\Composers;

use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use Illuminate\Contracts\View\View;
use Gate;


class PageComposer
{
    /**
     * @var \Illuminate\Routing\Route|null
     */
    protected $route;

    public function compose(View $view)
    {
        $this->route = \Request::route();
        $predefined = [
            'menus'              => $this->getMenu(),
            'current_route_name' => $this->route->getName(),
            'query_log'          => performance()->getSql(),
        ];
        $view_data = array_diff_key($predefined, $view->getData());
        foreach ($view_data as $key => $value) {
            $view->with($key, $value);
        }
    }

    private function getMenu()
    {
        $menus = [
            [
                'title'     => '供应商管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '品牌信息填写', //供应商列表
                        'icon'     => '&#xe685;',
                        'route'    => route('provider.provider.index'),
                        'visible'  => $this->getVisible('provider.provider.index'),
                        'selected' => $this->getMenuSelected('供应商列表'),
                    ],
                    [
                        'title'    => '供应商排名',
                        'icon'     => '&#xe611;',
                        'route'    => route('provider.provider-rank-category.index'),
                        'visible'  => $this->getVisible('provider.provider-rank-category.index'),
                        'selected' => $this->getMenuSelected('供应商排名'),
                    ],
                    [
                        'title'    => '供应商评论',
                        'icon'     => '&#xe611;',
                        'route'    => route('brand.comments', ['pid' => 0]),
                        'visible'  => $this->getVisible('brand.comments'),
                        'selected' => $this->getMenuSelected('供应商评论'),
                    ],
                ],
            ],
            [
                'title'     => '产品管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '产品分类',
                        'icon'     => '&#xe60e;',
                        'route'    => route('product.product-category.index'),
                        'visible'  => $this->getVisible('product.product-category.index'),
                        'selected' => $this->getMenuSelected('产品分类'),
                    ],
                    [
                        'title'    => '工程产品填写', //工程产品列表
                        'icon'     => '&#xe6b9;',
                        'route'    => route('product.index'),
                        'visible'  => $this->getVisible('product.index'),
                        'selected' => $this->getMenuSelected('产品列表'),
                    ],
                    [
                        'title'    => '产品评论',
                        'icon'     => '&#xe66c;',
                        'route'    => route('product.comments', ['pid' => 0]),
                        'visible'  => $this->getVisible('product.comments'),
                        'selected' => $this->getMenuSelected('产品评论'),
                    ],
                ],
            ],
            [
                'title'     => '后台设置',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '角色管理',
                        'icon'     => '&#xe600;',
                        'route'    => route('role.role.index'),
                        'visible'  => $this->getVisible('role.role.index'),
                        'selected' => $this->getMenuSelected('角色管理'),
                    ],
                    [
                        'title'    => '用户管理',
                        'icon'     => '&#xe65f;',
                        'route'    => route('role.user.index'),
                        'visible'  => $this->getVisible('role.user.index'),
                        'selected' => $this->getMenuSelected('用户管理'),
                    ],
                    [
                        'title'    => '广告管理',
                        'icon'     => '&#xe627;',
                        'route'    => route('advertisement.advertisement.index'),
                        'visible'  => $this->getVisible('advertisement.advertisement.index'),
                        'selected' => $this->getMenuSelected('广告管理'),
                    ],
                    [
                        'title'    => '用户消息',
                        'icon'     => '&#xe619;',
                        'route'    => route('msg.user-msg.index'),
                        'visible'  => $this->getVisible('msg.user-msg.index'),
                        'selected' => $this->getMenuSelected('用户消息'),
                    ],
                    [
                        'title'    => '广播消息',
                        'icon'     => '&#xe61a;',
                        'route'    => route('msg.broadcast-msg.index'),
                        'visible'  => $this->getVisible('msg.broadcast-msg.index'),
                        'selected' => $this->getMenuSelected('广播消息'),
                    ],
                    [
                        'title'    => '区域设置',
                        'icon'     => '&#xe609;',
                        'route'    => route('regional.china-area.index'),
                        'visible'  => $this->getVisible('regional.china-area.index'),
                        'selected' => $this->getMenuSelected('区域设置'),
                    ],
                    [
                        'title'    => '省份设置',
                        'icon'     => '&#xe64a;',
                        'route'    => route('regional.province.index'),
                        'visible'  => $this->getVisible('regional.province.index'),
                        'selected' => $this->getMenuSelected('省份设置'),
                    ],
                    [
                        'title'    => '城市设置',
                        'icon'     => '&#xe611;',
                        'route'    => route('regional.city.index'),
                        'visible'  => $this->getVisible('regional.city.index'),
                        'selected' => $this->getMenuSelected('城市设置'),
                    ],

                ],
            ],
            [
                'title'     => '品类管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '品类管理',
                        'icon'     => '&#xe60e;',
                        'route'    => route('category.category.index'),
                        'visible'  => $this->getVisible('category.category.index'),
                        'selected' => $this->getMenuSelected('品类管理'),
                    ],
                ],
            ],
            [
                'title'     => '属性管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '属性管理',
                        'icon'     => '&#xe60e;',
                        'route'    => route('category.attribute.index'),
                        'visible'  => $this->getVisible('category.attribute.index'),
                        'selected' => $this->getMenuSelected('属性管理'),
                    ],
                ],
            ],
            [
                'title'     => '客户管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '客户账号列表',
                        'icon'     => '&#xe604;',
                        'route'    => route('fq-user.fq-user.index'),
                        'visible'  => $this->getVisible('fq-user.fq-user.index'),
                        'selected' => $this->getMenuSelected('客户账号列表'),
                    ],
                    [
                        'title'    => '客户反馈列表',
                        'icon'     => '&#xe65f;',
                        'route'    => route('fq-user.fq-user-feedback.index'),
                        'visible'  => $this->getVisible('fq-user.fq-user-feedback.index'),
                        'selected' => $this->getMenuSelected('客户反馈列表'),
                    ],
                ],
            ],
            [
                'title'     => '开发商管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '开发商列表',
                        'icon'     => '&#xe65c;',
                        'route'    => route('developer.developer.index'),
                        'visible'  => $this->getVisible('developer.developer.index'),
                        'selected' => $this->getMenuSelected('开发商列表'),
                    ],
                    [
                        'title'    => '楼盘管理',
                        'icon'     => '&#xe611;',
                        'route'    => route('developer.loupan.index'),
                        'visible'  => $this->getVisible('developer.loupan.index'),
                        'selected' => $this->getMenuSelected('楼盘管理'),
                    ],
                    [
                        'title'    => '项目分类',
                        'icon'     => '&#xe603;',
                        'route'    => route('developer.project-category.index'),
                        'visible'  => $this->getVisible('developer.project-category.index'),
                        'selected' => $this->getMenuSelected('项目分类'),
                    ],
                ],
            ],
            [
                'title'     => '供应商审核',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '企业证书审核',
                        'icon'     => '&#xe6b9;',
                        'route'    => route('provider.provider-certificate.list'),
                        'visible'  => $this->getVisible('provider.provider-certificate.list'),
                        'selected' => $this->getMenuSelected('企业证书审核'),
                    ],
                    [
                        'title'    => '服务网点审核',
                        'icon'     => '&#xe609;',
                        'route'    => route('provider.provider-service-network.list'),
                        'visible'  => $this->getVisible('provider.provider-service-network.list'),
                        'selected' => $this->getMenuSelected('服务网点审核'),
                    ],
                    [
                        'title'    => '战略合作商审核',
                        'icon'     => '&#xe66c;',
                        'route'    => route('provider.provider-friend.list'),
                        'visible'  => $this->getVisible('provider.provider-friend.list'),
                        'selected' => $this->getMenuSelected('战略合作商审核'),
                    ],
                    [
                        'title'    => '宣传图片审核',
                        'icon'     => '&#xe6c3;',
                        'route'    => route('provider.provider-propaganda.list'),
                        'visible'  => $this->getVisible('provider.provider-propaganda.list'),
                        'selected' => $this->getMenuSelected('宣传图片审核'),
                    ],
                    [
                        'title'    => '历史项目审核',
                        'icon'     => '&#xe603;',
                        'route'    => route('provider.provider-project.list'),
                        'visible'  => $this->getVisible('provider.provider-project.list'),
                        'selected' => $this->getMenuSelected('历史项目审核'),
                    ],
                    [
                        'title'    => '企业动态审核',
                        'icon'     => '&#xe64a;',
                        'route'    => route('provider.provider-news.list'),
                        'visible'  => $this->getVisible('provider.provider-news.list'),
                        'selected' => $this->getMenuSelected('企业动态审核'),
                    ],
                    [
                        'title'    => '产品方案审核',
                        'icon'     => '&#xe607;',
                        'route'    => route('provider.provider-product.list'),
                        'visible'  => $this->getVisible('provider.provider-product.list'),
                        'selected' => $this->getMenuSelected('产品方案审核'),
                    ],
                    [
                        'title'    => '方案审核',
                        'icon'     => '&#xe608;',
                        'route'    => route('provider.provider-product-programme.list'),
                        'visible'  => $this->getVisible('provider.provider-product-programme.list'),
                        'selected' => $this->getMenuSelected('方案审核'),
                    ],
                ],
            ],
            [
                'title'     => '内容发布管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '分类管理',
                        'icon'     => '&#xe685;',
                        'route'    => route('content-publish.category.index'),
                        'visible'  => $this->getVisible('content-publish.category.index'),
                        'selected' => $this->getMenuSelected('分类管理'),
                    ],
                    [
                        'title'    => '内容管理',
                        'icon'     => '&#xe611;',
                        'route'    => route('content-publish.content.index'),
                        'visible'  => $this->getVisible('content-publish.content.index'),
                        'selected' => $this->getMenuSelected('内容管理'),
                    ],
                ],
            ],
            [
                'title'     => '展会广告图标管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '合作机构媒体',
                        'icon'     => '&#xe685;',
                        'route'    => route('media-management.index'),
                        'visible'  => $this->getVisible('media-management.index'),
                        'selected' => $this->getMenuSelected('合作机构媒体'),
                    ],

                ],
            ],
            [
                'title'     => '文章管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '文章列表',
                        'icon'     => '&#xe685;',
                        'route'    => route('information.index'),
                        'visible'  => $this->getVisible('information.index'),
                        'selected' => $this->getMenuSelected('文章管理'),
                    ],
                    [
                        'title'    => '文章评论',
                        'icon'     => '&#xe611;',
                        'route'    => route('information.comments', ['pid' => 0]),
                        'visible'  => $this->getVisible('information.comments'),
                        'selected' => $this->getMenuSelected('文章评论'),
                    ],

                ],
            ],
            [
                'title'     => '关键词管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '关键词列表',
                        'icon'     => '&#xe685;',
                        'route'    => route('theme.index'),
                        'visible'  => $this->getVisible('theme.index'),
                        'selected' => $this->getMenuSelected('关键词管理'),
                    ],
                ],
            ],
            [
                'title'     => '标签管理',
                'route'     => '',
                'visible'   => true,
                'selected'  => false,
                'sub_items' => [
                    [
                        'title'    => '标签列表',
                        'icon'     => '&#xe685;',
                        'route'    => route('tag.index'),
                        'visible'  => $this->getVisible('theme.index'),
                        'selected' => $this->getMenuSelected('标签管理'),
                    ],
                ],
            ],
        ];

        foreach ($menus as &$menu) {
            $this->setMenuVisible($menu);
        }


        return $menus;
    }


    public function setMenuVisible(&$menu)
    {
        if (isset($menu['sub_items']) && !empty($menu['sub_items'])) {
            $menu['visible'] = $this->getMenuVisible($menu['sub_items']);
            foreach ($menu['sub_items'] as $sub_item) {
                $this->setMenuVisible($sub_item);
            }
        }
    }


    public function getMenuVisible($sub_items)
    {
        if (empty($sub_items)) {
            return false;
        }
        foreach ($sub_items as $sub_item) {
            if ($sub_item['visible']) {
                return true;
            }
        }
        return false;
    }

    public function getMenuSelected($route_name)
    {
        $menus = config('menu');
        $name = request()->route()->getName();
        if (isset($menus[$route_name])) {
            if (in_array($name, $menus[$route_name])) {
                return true;
            }
        }
        return false;
    }


    public function getVisible($route_name)
    {
        $user_id = request()->user()->id;
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        if ($fq_user_entity->role_type == FqUserRoleType::PROVIDER) {
            if (in_array($route_name, ['provider.provider.index', 'product.index'])) {
                return true;
            } else {
                return false;
            }
        } else if ($fq_user_entity->role_type == FqUserRoleType::ADMIN) {
            return true;
        }
        return false;
        //return Gate::allows($route_name);
    }


}