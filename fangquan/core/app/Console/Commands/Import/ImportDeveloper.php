<?php

namespace App\Console\Commands\Import;

use App\Service\QiNiu\QiNiuService;
use App\Src\Developer\Domain\Model\DeveloperStatus;
use App\Src\Developer\Infra\Eloquent\DeveloperModel;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDeveloper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:developer';

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
        $qi_niu_service = new QiNiuService();
        $developers = DB::connection('spider')->select("select * from `fortune100_developers`");
        foreach ($developers as $developer) {
            $developer_model = DeveloperModel::find($developer->id);
            if (!isset($developer_model)) {
                $developer_model = new DeveloperModel();
            }
            $file = download($developer->logo, 'developer');
            $image_result = $qi_niu_service->upload($file);
            unlink($file);
            if (is_array($image_result)) {
                $developer_model->id = $developer->id;
                $developer_model->name = $developer->long_name;
                $developer_model->logo = $image_result['id'];
                $developer_model->status = DeveloperStatus::YES;
                $developer_model->rank = $developer->rank;
                $developer_model->save();
                $this->info($developer->long_name . ': 导入成功');
            } else {
                $this->error($developer->long_name . ': 上传图片失败');
            }
        }
        $this->info('导入结束');
    }
}
