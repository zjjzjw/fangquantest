<?php

namespace App\Wap\Http\Controllers\Exhibition;

use App\Src\Content\Infra\Repository\UserInfoRepository;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Wap\Http\Controllers\BaseController;
use App\Wap\Service\Weixin\WeixinService;
use Illuminate\Http\Request;

class GatherController extends BaseController
{
    public function register(Request $request)
    {
        $this->title = '登录注册';
        $type = $request->get('type');

        $user_id = $request->user()->id;

        $fq_user_repository = new FqUserRepository();
        $fq_user_repository->updateRoleType($user_id, $type);

        $user_info_repository = new UserInfoRepository();
        $user_info_entity = $user_info_repository->getUserInfoByUserId($user_id);
        if (isset($user_info_entity)) {
            return redirect()->to(route('exhibition.gather.agenda'));
        }

        $this->file_css = 'pages.exhibition.gather.register';
        $this->file_js = 'pages.exhibition.gather.register';
        $data = [];
        return $this->view('pages.exhibition.gather.register', $data);
    }

    public function shadowe()
    {
        $this->title = '问卷调查';
        $data = [];
        $this->file_css = 'pages.exhibition.gather.shadowe';
        $this->file_js = 'pages.exhibition.gather.shadowe';
        return $this->view('pages.exhibition.gather.shadowe', $data);
    }

    public function agenda(Request $request)
    {
        $data = [];
        $this->title = '会议流程';
        $user_id = $request->user()->id;


        $fq_user_repository = new FqUserRepository();
        /** @var FqUserEntity $fq_user_entity */
        $fq_user_entity = $fq_user_repository->fetch($user_id);
        $data['type'] = $fq_user_entity->role_type;
        $this->file_css = 'pages.exhibition.gather.agenda';
        $this->file_js = 'pages.exhibition.gather.agenda';
        return $this->view('pages.exhibition.gather.agenda', $data);
    }


    public function token(Request $request)
    {
        $weixin_service = new  WeixinService();
        $data = $weixin_service->signature($request);
        return $data;

    }

    public function callback(Request $request)
    {
        $content = $request->getContent();
        $weixin_service = new WeixinService();
        $data = $weixin_service->xmlToArray($content);

        \Log::info($data);
        //switch
        switch ($data['MsgType']) {
            //如果消息类型是事件
            case "event":
                //获取事件操作
                $Event = $data['Event'];
                //switch
                switch ($Event) {
                    //关注事件
                    case "subscribe":
                        $weixin_service->sendText($data['FromUserName']);
                        break;
                    //取消关注
                    case "unsubscribe":
                        break;
                    //菜单点击事件
                    case "VIEW":

                        break;
                }
                break;
            //如果是文字消息
            case 'text':
                switch ($data['Content']) {
                    case "1":
                        //封装图文消息
                        break;
                    default:
                        break;
                }
                break;
            //如果是图片消息
            case 'image':
                break;

        }
    }
}


