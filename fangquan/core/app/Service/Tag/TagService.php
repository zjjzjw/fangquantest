<?php

namespace App\Service\Tag;


use App\Src\Tag\Domain\Model\TagEntity;
use App\Src\Tag\Domain\Model\TagSpecification;
use App\Src\Tag\Domain\Model\TagType;
use App\Src\Tag\Infra\Repository\TagRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TagService
{
    /**
     * @param TagSpecification $spec
     * @param int              $per_page
     * @return array
     */
    public function getTagList(TagSpecification $spec, $per_page)
    {
        $data = [];
        $tag_repository = new TagRepository();
        $tag_type = TagType::acceptableEnums();
        $paginate = $tag_repository->search($spec, $per_page);
        $items = [];
        /**
         * @var int                  $key
         * @var TagEntity            $tag_entity
         * @var LengthAwarePaginator $paginate
         */
        foreach ($paginate as $key => $tag_entity) {
            $item = $tag_entity->toArray();
            $item['type_name'] = $tag_type[$item['type']] ?? '';
            $items[] = $item;
        }
        $data['paginate'] = $paginate;
        $data['items'] = $items;
        $data['pager']['total'] = $paginate->total();
        $data['pager']['last_page'] = $paginate->lastPage();
        $data['pager']['current_page'] = $paginate->currentPage();

        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public function getTagInfo($id)
    {
        $data = [];
        $tag_repository = new TagRepository();
        /** @var TagEntity $tag_entity */
        $tag_entity = $tag_repository->fetch($id);
        if (isset($tag_entity)) {
            $data = $tag_entity->toArray();
        }
        return $data;
    }

    public function getTagLists()
    {
        $data = [];
        $tag_repository = new TagRepository();
        $tag_entities = $tag_repository->all();
        foreach ($tag_entities as $tag_entity) {
            $item = $tag_entity->toArray();
            $data[] = $item;
        }
        return $data;
    }
}

