<?php

namespace App\Admin\Src\Forms\Project;

use App\Src\Project\Infra\Repository\ProjectCategoryRepository;
use App\Src\Project\Domain\Model\ProjectCategoryEntity;
use App\Admin\Src\Forms\Form;

/**
 * @property mixed project_category_entity
 */
class ProjectCategoryStoreForm extends Form
{
    /** @var  ProjectCategoryEntity */
    public $project_category_entity;

    public function validation()
    {
        $attrib = json_encode($this->regroupAttrib($this->data));
        if ($id = array_get($this->data, 'id')) { //修改
            $project_category_repository = new ProjectCategoryRepository();
            /** @var ProjectCategoryEntity $project_category_entity */
            $project_category_entity = $project_category_repository->fetch($id);
        } else {
            $project_category_entity = new ProjectCategoryEntity();
            if (($level = array_get($this->data, 'level')) < 3) {
                $project_category_entity->is_leaf = 0;
            } else {
                $project_category_entity->is_leaf = 1;
            }
            $project_category_entity->parent_id = array_get($this->data, 'parent_id');
            $project_category_entity->level = $level;
        }
        $project_category_entity->attribfield = $attrib;
        $project_category_entity->sort = array_get($this->data, 'sort');
        $project_category_entity->name = array_get($this->data, 'name');
        $project_category_entity->status = array_get($this->data, 'status');
        $project_category_entity->logo = array_get($this->data, 'logo');
        $project_category_entity->icon_font = array_get($this->data, 'icon_font');
        $project_category_entity->description = array_get($this->data, 'description') ?? '';
        $this->project_category_entity = $project_category_entity;

    }

    /**
     * 重组产品参数属性为json数据
     * @param $params
     * @return string
     */
    public function regroupAttrib($params)
    {


        $items = [];
        $result = [];
        if (!empty($params['project'])) {
            $categories = $params['project'];
            $result['name'] = $categories['category-param-name'];
            $result['key'] = $categories['category-param-key'];
            $result['param'] = [];
            foreach ($categories as $key => $param) {
                if (strpos($key, 'category-param') !== false && strpos($key, 'category-param-') === false) {
                    $result['param'][] = $param;
                }
            }
            $result = $this->formatDataFromHorToVert($result);

            foreach ($result as $row) {
                $item = [];
                $item['id'] = $row['key'];
                $item['name'] = $row['name'];
                $item['type'] = 'string';
                $item['key'] = $row['key'];
                $item['value'] = '';
                $item['nodes'] = [];
                if (!empty($row['param'])) {
                    $params = $this->formatDataFromHorToVert($row['param']);
                    foreach ($params as $param) {
                        $param_item = [];
                        $param_item['id'] = $param['param-key'];
                        $param_item['name'] = $param['param-name'];
                        $param_item['type'] = 'string';
                        $param_item['key'] = $param['param-key'];
                        $param_item['value'] = '';
                        $item['nodes'][] = $param_item;
                    }
                }
                $items[] = $item;
            }
        }
        return $items;
    }

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string',
            'status'    => 'required|integer',
            'sort'      => 'required|integer',
            'project'   => 'nullable|array',
            'logo'      => 'nullable|integer',
            'icon_font' => 'nullable|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
        ];
    }

    public function attributes()
    {
        return [
            'name'        => '分类名称',
            'status'      => '分类显示状态',
            'sort'        => '排序',
            'description' => '描述',
            'level'       => 'level',
            'is_leaf'     => 'is_leaf',
            'parent_id'   => 'parent_id',
            'attribfield' => 'attribfield',
            'logo'        => 'logo',
            'icon_font'   => 'icon_font',
        ];
    }


}