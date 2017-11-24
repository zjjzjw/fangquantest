<?php

namespace App\Console\Commands\Import;

use App\Service\QiNiu\QiNiuService;
use App\Src\Brand\Domain\Model\BrandEntity;
use App\Src\Brand\Infra\Eloquent\BrandDomesticImportModel;
use App\Src\Brand\Infra\Eloquent\BrandModel;
use App\Src\Brand\Infra\Repository\BrandRepository;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectCategoryTypeModel;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use App\Src\Surport\Infra\Eloquent\ResourceModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDeveloperProjectCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:developer_project_category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_entities = $developer_project_repository->all();
        /** @var DeveloperProjectEntity $developer_project_entity */
        foreach ($developer_project_entities as $developer_project_entity) {
            if ($developer_project_entity->project_category) {
                $developer_project_category_type_model = DeveloperProjectCategoryTypeModel::query();
                $developer_project_category_type['project_id'] = $developer_project_entity->id;
                $developer_project_category_type['project_category_id'] = $developer_project_entity->project_category;
                $developer_project_category_type_model->firstOrCreate($developer_project_category_type);
                $this->info('导入成功！');
            }
        }
        $this->info('导入完成！');
    }
}
