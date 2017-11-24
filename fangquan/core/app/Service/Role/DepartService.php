<?php

namespace App\Service\Role;


use App\Src\Role\Domain\Model\DepartEntity;
use App\Src\Role\Infra\Repository\DepartRepository;

class DepartService
{
    public function getStructureDeparts()
    {
        $items = [];
        $depart_repository = new DepartRepository();
        $depart_entities = $depart_repository->all();
        /** @var DepartEntity $depart_entity */
        foreach ($depart_entities as $depart_entity) {
            $item = $depart_entity->toArray();
            $items[$depart_entity->id] = $item;
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


    public function getTreeHtml($tree, &$html, $depart_ids)
    {
        $display = '';
        if (($tree['level'] ?? 0) > 1) {
            $display = 'display: none';
        };
        $checked = '';
        if (in_array($tree['id'], $depart_ids)) {
            $checked = 'checked';
        }
        $next_level = $tree['level'] + 1;

        $html .= <<< DOC
                    <li data-li-level="{$tree['level']}">
                        <a href="javascript:void(0);" class="expand"><i class="iconfont">&#xe623;</i></a>
                        <input type="checkbox"  {$checked} class="has-child" name="organization[]" value="{$tree['id']}" data-level="{$tree['level']}"/>
                        <label><i class="iconfont">&#xe671;</i>{$tree['name']}</label>
                        <ul data-ul-level="{$next_level}" style="display: none;">
DOC;
        foreach ($tree['nodes'] as $node) {
            if (!empty($node['nodes'])) {
                $this->getTreeHtml($node, $html, $depart_ids);
            } else {
                $node_checked = '';
                if (in_array($node['id'], $depart_ids)) {
                    $node_checked = 'checked';
                }
                $html .= <<< DOC
                        <li data-li-level="{$node['level']}">
                            <input type="checkbox"  {$node_checked} name="organization[]" value="{$node['id']}" data-level="{$node['level']}"/>
                                     <label><i class="iconfont">&#xe7b6;</i>{$node['name']}</label>
                        </li>
DOC;
            }
        }

        $html .= <<< DOC
                 </ul>
                 </li>
        
DOC;
    }

}

