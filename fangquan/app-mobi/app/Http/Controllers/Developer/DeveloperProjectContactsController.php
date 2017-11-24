<?php

namespace App\Mobi\Http\Controllers\Developer;

use App\Mobi\Http\Controllers\BaseController;
use App\Mobi\Service\Developer\DeveloperProjectContactMobiService;
use App\Service\FqUser\CheckTokenService;
use App\Src\Exception\LoginException;
use Illuminate\Http\Request;

class DeveloperProjectContactsController extends BaseController
{
    public function projectContacts(Request $request, $id)
    {
        if (!CheckTokenService::isLogin()) {
            throw new LoginException('', LoginException::ERROR_NO_LOGIN);
        }
        $data = [];
        $developer_project_contact_mobi_service = new DeveloperProjectContactMobiService();
        $project_contacts = $developer_project_contact_mobi_service->getDeveloperProjectContactByProjectId($id);
        $data['code'] = 200;
        $data['msg'] = 'success';
        $data['data'] = $project_contacts;
        return response()->json($data, 200);
    }

}


