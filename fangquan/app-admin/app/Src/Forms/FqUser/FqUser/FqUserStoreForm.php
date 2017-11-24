<?php

namespace App\Admin\Src\Forms\FqUser\FqUser;

use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Src\Developer\Infra\Eloquent\DeveloperModel;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Admin\Src\Forms\Form;
use Carbon\Carbon;


class FqUserStoreForm extends Form
{
    /**
     * @var FqUserEntity
     */
    public $fq_user_entity;

    /**
     * validate data by value object;
     * and transform data to valueObject
     */
    protected function validation()
    {
        $company_name = array_get($this->data, 'company_name');

        $fq_user_repository = new FqUserRepository();
        $fq_user_entity = $fq_user_repository->getUserByAccount(array_get($this->data, 'account'));

        if ($fq_user_entity->isNotEmpty()) {
            if ($fq_user_entity[0]->id != array_get($this->data, 'id')) {
                $this->addError('account', '不能重复！');
            }
        }
        if (array_get($this->data, 'id')) {
            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch(array_get($this->data, 'id'));
            $fq_user_entity->role_id = array_get($this->data, 'role_id');
        } else {
            $fq_user_entity = new FqUserEntity();
            $fq_user_entity->nickname = array_get($this->data, 'account');
            $fq_user_entity->platform_id = array_get($this->data, 'platform_id');
            $fq_user_entity->register_type_id = array_get($this->data, 'register_type_id');
            $fq_user_entity->role_type = FqUserRoleType::UNKNOWN;
            $fq_user_entity->role_id = 0;
            $fq_user_entity->reg_time = Carbon::now();
            $fq_user_entity->password = '';
            $fq_user_entity->salt = '';
            $fq_user_entity->email = '';
            $fq_user_entity->avatar = 0;
            $fq_user_entity->mobile = '';
        }

        $fq_user_entity->mobile = array_get($this->data, 'mobile') ?? '';
        $fq_user_entity->account = array_get($this->data, 'account');
        $fq_user_entity->project_category = array_get($this->data, 'project_category') ? implode(',', array_get($this->data, 'project_category')) : '';
        $fq_user_entity->project_area = array_get($this->data, 'project_area') ? implode(',', array_get($this->data, 'project_area')) : '';
        $fq_user_entity->account_type = array_get($this->data, 'account_type');
        $fq_user_entity->expire = array_get($this->data, 'expire');
        $fq_user_entity->status = array_get($this->data, 'status');
        $fq_user_entity->admin_id = request()->user()->id;
        $fq_user_entity->company_name = $company_name;

        $this->fq_user_entity = $fq_user_entity;
    }


    /**
     * Get the validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'id'               => 'required|integer',
            'account_type'     => 'nullable|integer',
            'project_area'     => 'nullable|array',
            'project_category' => 'nullable|array',
            'expire'           => 'nullable|string',
            'status'           => 'required|integer',
            'account'          => 'nullable|string',
            'company_name'     => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'id'               => '标识',
            'account'          => '客户账号',
            'company_name'     => '公司名称',
            'project_category' => '账号权限分类',
            'project_area'     => '账号权限地区',
            'account_type'     => '账号类型',
            'expire'           => '过期时间',
            'status'           => '账号状态',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }


    public function uniqueCompanyName($role_type, $company_name)
    {
        $exist_model = null;
        if (intval($role_type) === FqUserRoleType::PROVIDER) {
            $exist_model = ProviderModel::where('company_name', $company_name)->first();
        }
        if (intval($role_type) === FqUserRoleType::DEVELOPER) {
            $exist_model = DeveloperModel::where('name', $company_name)->first();
        }

        if (!is_null($exist_model)) {
            $this->addError('company_name', '企业名称重复。');
        }
    }
}