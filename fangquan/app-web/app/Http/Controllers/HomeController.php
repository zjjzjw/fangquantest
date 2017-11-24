<?php

namespace App\Web\Http\Controllers;

use App\Service\ContentPublish\ContentService;
use App\Service\Developer\DeveloperProjectService;
use App\Service\Developer\DeveloperService;
use App\Service\Provider\ProviderService;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Jenssegers\Agent\Agent;


class HomeController extends BaseController
{
    public function index()
    {
        $data = [];
        //项目信息

        $developer_project_service = new DeveloperProjectService();
        $developer_projects = $developer_project_service->getTopDeveloperProjects(
            3, DeveloperProjectStatus::YES
        );
        $data['developer_projects'] = $developer_projects;
        //品牌信息
        $provider_repository = new ProviderRepository();
        $data['provider_count'] = $provider_repository->getProviderCount();
        $provider_ids = [269, 139, 488, 80, 489, 490, 457, 341, 402, 253];
        $provider_service = new ProviderService();
        $providers = $provider_service->getProvidersByIds($provider_ids);
        $data['providers'] = $providers;

        return $this->view('pages.home.index', $data);
    }


    public function exhibition()
    {
        $data = [];

        $agent = new Agent();
        $browser = $agent->browser();
        $version = $agent->version($browser);

        //开发商数据
        $developer_ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $developer_service = new DeveloperService();
        $developers = $developer_service->getDevelopersByIds($developer_ids);
        $data['developers'] = $developers;

        //供应商数据
        $provider_ids = [269, 139, 488, 80, 489, 490, 457, 341, 402, 253];
        $provider_service = new ProviderService();
        $providers = $provider_service->getProvidersByIds($provider_ids);
        $data['providers'] = $providers;

        $content_service = new ContentService();
        $data['banners'] = $content_service->getContentListByType(19, 5);
        $data['browser'] = $browser;
        $data['version'] = $version;

        return $this->view('pages.home.exhibition', $data);
    }

}


