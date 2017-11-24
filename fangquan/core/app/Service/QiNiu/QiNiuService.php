<?php

namespace App\Service\QiNiu;

// 引入鉴权类
use App\Src\Surport\Infra\Repository\ResourceRepository;
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class QiNiuService
{

    private $access_key;
    private $secret_key;
    private $bucket;

    public function __construct()
    {
        $this->access_key = getenv('STORAGE_QINIU_ACCESS_KEY');
        $this->secret_key = getenv('STORAGE_QINIU_SECRET_KEY');
        $this->bucket = getenv('STORAGE_QINIU_DEFAULT_BUCKET');
    }

    /**
     * 七牛上传文件
     * @param $file_path string 文件路径
     */
    public function upload($file_path)
    {
        // 构建鉴权对象
        $auth = new Auth($this->access_key, $this->secret_key);

        $resource_repository = new ResourceRepository();
        $token = $resource_repository->uploadToken($this->bucket);

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, null, $file_path);
        //echo "\n====> putFile result: \n";
        if ($err !== null) {
            return $err;
        } else {
            return $ret;
        }
    }

    /**
     * 删除文件
     * @param $file_name string 文件名
     */
    public function delete($file_name)
    {
        //初始化Auth状态：
        $auth = new Auth($this->access_key, $this->secret_key);

        //初始化BucketManager
        $bucketMgr = new BucketManager($auth);

        $bucket = $this->bucket;

        $err = $bucketMgr->delete($bucket, $file_name);
        echo "\n====> delete $file_name : \n";
        if ($err !== null) {
            var_dump($err);
        } else {
            echo "Success!";
        }
    }
}