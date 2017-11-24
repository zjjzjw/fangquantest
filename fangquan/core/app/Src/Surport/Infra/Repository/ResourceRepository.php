<?php namespace App\Src\Surport\Infra\Repository;

use App\Admin\Http\Controllers\Api\QiniuController;
use App\Foundation\Domain\Repository;
use App\Src\Surport\Domain\Interfaces\ResourceInterface;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Eloquent\ResourceModel;
use Qiniu\Processing\Operation;
use Qiniu\Storage\BucketManager;
use Carbon\Carbon;
use Qiniu\Auth;

class ResourceRepository extends Repository implements ResourceInterface
{
    /**
     * 用于和七牛服务器交互
     *
     * @var Auth
     */
    private $auth;

    /**
     * 各个bucket的基本信息
     * 比如对应的url, 是否私有空间等
     *
     * @var array
     */
    private $bucket_info = [
        'fq-img'     => [
            'domain'  => 'img.fq960.com',
            'private' => false,
        ],
        'fq-img-dev' => [
            'domain'  => 'img-dev.fq960.com',
            'private' => false,
        ],
    ];

    public function __construct()
    {
        $this->auth = new Auth(env('STORAGE_QINIU_ACCESS_KEY'), env('STORAGE_QINIU_SECRET_KEY'));
    }


    /**
     * Store an entity to repository.
     *
     * @param ResourceEntity $resource_entity
     */
    protected function store($resource_entity)
    {
        if ($resource_entity->isStored()) {
            $model = ResourceModel::find($resource_entity->id);
        } else {
            $model = new ResourceModel();
        }
        $model->fill(
            [
                'bucket'         => $resource_entity->bucket,
                'hash'           => $resource_entity->hash,
                'processed_hash' => $resource_entity->processed_hash,
                'mime_type'      => $resource_entity->mime_type,
                'desc'           => $resource_entity->desc,
            ]
        );
        $model->save();
        $resource_entity->url = $this->url($model);
        $resource_entity->setIdentity($model->id);

    }

    /**
     * Reconstitute transaction by sn. (Factory)
     *
     * @param mixed $sn
     * @param array $params Additional params.
     * @return null
     */
    protected function reconstitute($id, $params = [])
    {
        $model = ResourceModel::find($id);
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


    /**
     * Reconstitute transaction by model.
     *
     * @param mixed $model
     * @return mixed
     */
    protected function reconstituteFromModel($model)
    {
        $resource_entity = new ResourceEntity();
        $resource_entity->id = $model->id;
        $resource_entity->bucket = $model->bucket;
        $resource_entity->hash = $model->hash;
        $resource_entity->desc = $model->desc;
        $resource_entity->mime_type = $model->mime_type;
        $resource_entity->processed_hash = $model->processed_hash;
        $resource_entity->url = $this->url($model);
        $resource_entity->created_at = Carbon::parse($model->created_at);
        $resource_entity->updated_at = Carbon::parse($model->updated_at);

        $resource_entity->setIdentity($model->id);
        $resource_entity->stored();

        return $resource_entity;
    }


    /**
     * 更新 source_entity 的 processed_hash 字段
     *
     * @param ResourceEntity $resource_entity
     * @param string         $processed_hash
     * @return ResourceEntity
     */
    public function setProcessedHash(ResourceEntity $resource_entity, $processed_hash)
    {
        $builder = ResourceModel::query();

        $processed_resource_model = $builder->where('hash', $processed_hash)
            ->where('bucket', $resource_entity->bucket)->first();

        if ($processed_resource_model) {
            // 删除旧的processed_resource
            $auth = new Auth(env('STORAGE_QINIU_ACCESS_KEY'), env('STORAGE_QINIU_SECRET_KEY'));
            $manager = new BucketManager($auth);
            $manager->delete($processed_resource_model->bucket, $processed_hash);
            $processed_resource_model->delete();
        }

        $resource_entity->processed_hash = $processed_hash;
        $this->store($resource_entity);

        return $resource_entity;
    }


    /**
     * @param $bucket_name
     * @return string
     */
    public function uploadToken($bucket_name)
    {
        $policy = [
            'callbackBody' => 'hash=$(etag)&bucket=$(bucket)&mimeType=$(mimeType)&fops=$(x:fops)',
            'callbackUrl'  => env('STORAGE_QINIU_CALLBACK_URL'),
        ];
        $token = $this->auth->uploadToken($bucket_name, null, 1200, $policy);
        return $token;
    }


    /**
     * @param ResourceEntity $resource_entity
     * @param array          $fops
     * @return string
     */
    public function privateUrlWithFop(ResourceEntity $resource_entity, array $fops)
    {
        $token_expire = 300;
        $bkt_info = $this->bucket_info[$resource_entity->bucket];

        if (count($fops) > 0) {
            $ops = new Operation($bkt_info['domain'], $this->auth, $token_expire);
            $url = $ops->buildUrl($resource_entity->hash, $fops);
        } else {
            $url = "http://" . $bkt_info['domain'] . "/" . $resource_entity->hash;
            $url = $this->auth->privateDownloadUrl($url, $token_expire);
        }
        return $url;
    }

    /**
     * @param array|int $ids
     * @return array
     */
    public function getResourceUrlByIds($ids)
    {
        $resource_entities = [];
        $builder = ResourceModel::query();
        $builder->whereIn('id', (array)$ids);
        $models = $builder->get();
        foreach ($models as $model) {
            $resource_entities[$model->id] = $this->reconstituteFromModel($model);
        }
        return $resource_entities;
    }

    /**
     * @param ResourceModel $model
     * @return string
     */
    protected function url($model)
    {
        $url = 'http://' . $this->bucket_info[$model->bucket]['domain'] . '/' . $model->hash;
        return $url;
    }

    /**
     *  得到下载地址
     * @param ResourceEntity $resource_entity
     * @param array          $fops
     * @return string
     */
    public function getDownloadUrl(ResourceEntity $resource_entity, array $fops)
    {

        $bkt_info = $this->bucket_info[$resource_entity->bucket];
        $ops = new Operation($bkt_info['domain'], $this->auth);
        $url = $ops->buildUrl($resource_entity->hash, $fops);
        $this->getUrlSize($bkt_info['domain']);
        return $url;
    }


    /**
     * 获取文件大小
     * @param $key
     * @return mixed
     */
    public function getUrlSize($key)
    {
        $bucket = env('STORAGE_QINIU_DEFAULT_BUCKET');
        $bucketMgr = new BucketManager($this->auth);
        $results = $bucketMgr->stat($bucket, $key);
        $result = current($results);
        return $result['fsize'];
    }

    /**
     * @param string $hash
     * @return mixed|null
     */
    public function getResourceByHash($hash)
    {
        $builder = ResourceModel::query();
        $builder->where('hash', $hash);
        $model = $builder->first();
        if (!isset($model)) {
            return null;
        }
        return $this->reconstituteFromModel($model);
    }


}

