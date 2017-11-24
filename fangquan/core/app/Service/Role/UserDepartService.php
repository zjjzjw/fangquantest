<?php

namespace App\Service\Role;


use App\Src\Role\Domain\Model\DepartEntity;
use App\Src\Role\Infra\Eloquent\UserDepartModel;
use App\Src\Role\Infra\Repository\DepartRepository;
use App\Src\Role\Infra\Repository\UserDepartRepository;

class UserDepartService
{
    public function getStructureDeparts()
    {
        $items = [];
        $depart_repository = new DepartRepository();
        $depart_entities = $depart_repository->all();

        $user_depart_repository = new UserDepartRepository();
        /** @var DepartEntity $depart_entity */
        foreach ($depart_entities as $depart_entity) {
            $item = $depart_entity->toArray();
            $items[$depart_entity->id] = $item;
            $user_depart_entities = $user_depart_repository->getUserDepartByDepartId($item['id']);
            $items[$depart_entity->id]['user_departs'] = $user_depart_entities->toArray();
        }
        $tree = $this->getTree($items);
        return $tree;
    }


    protected function getTree($items)
    {
        $tree = array();
        foreach ($items as $item) {
            if (isset($items[$item['parent_id']])) {
                $items[$item['parent_id']]['nodes'][] = &$items[$item['id']];
            } else {
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }


    public function getTreeHtml($tree, &$html, $user_roles)
    {
        $display = '';
        if (($tree['level'] ?? 0) > 1) {
            $display = 'display: none';
        };
        $checked = '';

        $next_level = $tree['level'] + 1;

        $html .= <<< DOC
                    <li data-li-level="{$tree['level']}">
                        <a href="javascript:void(0);" class="expand"><i class="iconfont">&#xe623;</i></a>
                        <input type="checkbox"  {$checked} class="has-child" name="organization[]" value="{$tree['id']}" data-level="{$tree['level']}"/>
                        <label><i class="iconfont">&#xe671;</i>{$tree['name']}</label>
                        <ul data-ul-level="{$next_level}" style="display: none;margin-left: 21px;">
DOC;
        foreach (($tree['nodes'] ?? []) as $node) {
            $this->getTreeHtml($node, $html, $user_roles);
        }

        foreach ($tree['user_departs'] as $user_depart) {
            $node_checked = '';
            foreach ($user_roles as $user_role) {
                if ($user_role->user_id == $user_depart->user->id) {
                    $node_checked = 'checked';
                }
            }

            $html .= <<< DOC
                        <li data-li-level="" style="margin-left: 21px;">
                            <input type="checkbox"  {$node_checked} name="user_roles[]" value="{$user_depart->user->id}" data-level=""/>
                                     <label><i class="iconfont">&#xe7b6;</i>{$user_depart->user->name}</label>
                        </li>
DOC;

        }
        $html .= <<< DOC
                 </ul>
                 </li>
        
DOC;
    }

}

