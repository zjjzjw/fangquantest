<?php namespace App\Src\Surport\Domain\Interfaces;

use App\Foundation\Domain\Interfaces\Repository;
use App\Src\Surport\Domain\Model\ResourceEntity;

interface ResourceInterface extends Repository
{
    /**
     * 更新 image_entity 的 processed_hash 字段
     *
     * @param ResourceEntity $resource_entity
     * @param string         $processed_hash
     * @return ResourceEntity
     */
    public function setProcessedHash(ResourceEntity $resource_entity, $processed_hash);


    /**
     * @param $bucket_name
     * @return string
     */
    public function uploadToken($bucket_name);

    /**
     * @param ResourceEntity $resource_entity
     * @param array          $fops
     * @return string
     */
    public function privateUrlWithFop(ResourceEntity $resource_entity, array $fops);

    /**
     * @param string $hash
     * @return mixed|null
     */
    public function getResourceByHash($hash);

}

