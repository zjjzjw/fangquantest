<?php namespace App\Service\Push;

use Xmpush\Constants;
use Xmpush\Builder;
use Xmpush\IOSBuilder;
use Xmpush\Sender;

/**
 * 小米推送服务
 * Class PushService
 * @package App\Service\Push
 */
class PushService
{
    /**
     * 向安卓手机推送消息
     * @param $reg_ids
     * @param $title
     */
    public function pushAndroidMessage($reg_ids, $title, $desc)
    {
        if (empty($desc)) {
            $desc = $title;
        } else {
            if (mb_strlen($desc) > 20) {
                $desc = mb_substr($desc, 0, 20) . "...";
            }
        }
        Constants::setPackage(Yii::$app->params['package']);
        Constants::setSecret(Yii::$app->params['xmpush_app_secret_android']);
        $message = new Builder();
        $message->title($title);
        $message->description($desc);
        $message->passThrough(0);
        $message->extra(Builder::notifyEffect, 1); // 此处设置预定义点击行为，1为打开app
        $message->extra(Builder::notifyForeground, 1);
        $message->notifyId(0);
        $message->build();
        $sender = new Sender();
        $result = $sender->sendToIds($message, $reg_ids);
        if ($result->getErrorCode() != 0) {
            $ids = implode(",", $reg_ids);
            $raw = $result->getRaw();
            Yii::getLogger()->log("Push to Android reg_ids ({$ids}) message: ({$title}) failed! reason: {$raw['reason']}, description:{$raw['description']}", Logger::LEVEL_ERROR);
        }
    }

    /**
     * 向苹果手机推送消息
     *
     * @param $reg_ids
     * @param $title
     */
    public function pushIOSMessage($reg_ids, $title)
    {
        Constants::setPackage(config('push')['bundle_id']);
        Constants::setSecret(config('push')['xmpush_app_secret_ios']);

        $message = new IOSBuilder();
        $message->description($title);
        $message->soundUrl('default');
        $message->badge(1);
        $message->build();

        $sender = new Sender();
        $result = $sender->sendToIds($message, $reg_ids);
        if ($result->getErrorCode() != 0) {
            $ids = implode(",", $reg_ids);
            $raw = $result->getRaw();
            \Log::error("Push to iOS reg_ids ({$ids}) message: ({$title}) failed! reason: {$raw['reason']}, description:{$raw['description']}");
        }
    }

}