<?php

namespace App\Wap\Http\Controllers\Exhibition;


use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use App\Wap\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
    //供应商问题
    public function providerQs()
    {
        $data = [];
        $this->title = '问卷调查';
        $this->file_css = 'pages.exhibition.question.provider-qs';
        $this->file_js = 'pages.exhibition.question.provider-qs';
        return $this->view('pages.exhibition.question.provider-qs', $data);
    }

    //开发商问题
    public function developerQs()
    {
        $data = [];
        $this->title = '问卷调查';
        $this->file_css = 'pages.exhibition.question.developer-qs';
        $this->file_js = 'pages.exhibition.question.developer-qs';
        return $this->view('pages.exhibition.question.developer-qs', $data);
    }
}