<?php

namespace App\Admin\Http\Controllers;


use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;


class BaseController extends Controller
{
    protected function view($view, $data = array())
    {
        $data = array_merge(
            [
                'basic_data'       => [
                    'user' => request()->user(),
                ],
                'meta_title'       => '房圈后台信息管理系统',
                'meta_keyword'     => '房圈后台信息管理系统',
                'meta_description' => '房圈后台信息管理系统',
            ],
            $data
        );
        return view($view, $data);
    }

    /**
     * 得到登录用户
     * @return FqUserEntity
     */
    public function getUserEntity()
    {
        $user = request()->user();
        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user->id);

        return $fq_user_entity;
    }
}




