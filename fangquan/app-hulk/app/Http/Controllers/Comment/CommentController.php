<?php

namespace App\Hulk\Http\Controllers\Comment;

use App\Hulk\Http\Controllers\BaseController;
use App\Hulk\Service\Comment\CommentHulkService;
use App\Hulk\Service\Information\InformationHulkService;
use App\Hulk\Service\Theme\ThemeHulkService;
use App\Hulk\Src\Forms\Comment\CommentStoreForm;
use App\Hulk\Src\Forms\Information\InformationSearchForm;
use App\Src\Brand\Domain\Model\CommentType;
use App\Src\Brand\Infra\Repository\CommentRepository;
use App\Src\Theme\Domain\Model\ThemeType;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    public function store(Request $request, CommentStoreForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $comment_repository = new CommentRepository();
        $comment_repository->save($form->comment_entity);
        $data['id'] = $form->comment_entity->id;
        return response()->json($data, 200);
    }
}


