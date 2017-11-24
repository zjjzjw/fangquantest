<?php

namespace App\Web\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Web\Service\Account\AccountService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class WeixinController extends Controller
{
    public function redirectToProvider(Request $request)
    {
        return Socialite::with('weixinweb')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user_data = Socialite::with('weixinweb')->user();
        $mobile_register = new  AccountService();
        $mobile_register->thirdPartyLogin($user_data);
        return redirect()->to(route('home.index'));

    }

}
