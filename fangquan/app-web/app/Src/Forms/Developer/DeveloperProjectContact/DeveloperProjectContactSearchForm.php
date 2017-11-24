<?php

namespace App\Web\Src\Forms\Developer\DeveloperProjectContact;

use App\Src\Developer\Domain\Model\DeveloperProjectContactSpecification;
use App\Admin\Src\Forms\Form;
use App\Src\FqUser\Domain\Model\FqUserAccountType;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use Carbon\Carbon;

class DeveloperProjectContactSearchForm extends Form
{
    /**
     * @var DeveloperProjectContactSpecification
     */
    public $developer_project_contact_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required' => ':attribute必填。',
            'integer'  => ':attribute必须整数',
        ];
    }

    public function validation()
    {
        if (request()->user()) {
            $time = Carbon::now();
            $fq_user_repository = new FqUserRepository();
            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch(request()->user()->id);
            if (isset($fq_user_entity)) {
                if ($fq_user_entity->expire < $time) {
                    $this->addError('project_id', '当前账户不能查看联系人信息，请联系客服');
                }
            }
        }
        $this->developer_project_contact_specification = new DeveloperProjectContactSpecification();
        $this->developer_project_contact_specification->developer_project_id = array_get($this->data, 'project_id');
    }
}