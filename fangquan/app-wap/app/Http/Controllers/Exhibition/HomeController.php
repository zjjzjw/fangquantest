<?php

namespace App\Wap\Http\Controllers\Exhibition;

use App\Src\FqUser\Domain\Model\ThirdPartyBindEntity;
use App\Src\FqUser\Infra\Repository\ThirdPartyBindRepository;
use App\Wap\Http\Controllers\BaseController;
use App\Wap\Service\Account\AccountService;
use App\Wap\Service\Weixin\WeixinService;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function exhibition(Request $request)
    {
        $this->title = '问卷调查';
        $code = $request->get('code');
        $state = $request->get('state');
        if (!\Auth::check()) {
            $weixin_service = new WeixinService();
            $user_token = $weixin_service->getUserToken($code);
            $open_id = $user_token['openid'];
            $third_party_bind_repository = new ThirdPartyBindRepository();
            /** @var ThirdPartyBindEntity $third_party_bind_entity */
            $third_party_bind_entity = $third_party_bind_repository->getThirdPartyByOpenId($open_id);
            if (isset($third_party_bind_entity)) {
                $user_id = $third_party_bind_entity->user_id;
                \Auth::loginUsingId($user_id);
            } else {
                $account_service = new AccountService();
                $user_id = $account_service->thirdPartyRegister($open_id, '', 0);
                \Auth::loginUsingId($user_id);
            }
        }
        $this->file_css = 'pages.exhibition.exhibition';
        $this->file_js = 'pages.exhibition.exhibition';
        $data = [];
        return $this->view('pages.exhibition.exhibition', $data);
    }
}


