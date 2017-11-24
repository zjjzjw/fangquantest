<?php

namespace App\Console\Commands\Import;

use App\Service\QiNiu\QiNiuService;
use App\Src\Developer\Domain\Model\DeveloperProjectContactType;
use App\Src\Developer\Domain\Model\DeveloperStatus;
use App\Src\Developer\Infra\Eloquent\DeveloperModel;
use App\Src\Developer\Infra\Eloquent\DeveloperProjectContactModel;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDeveloperProjectContact extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:developer:project:contact';

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

        //DeveloperProjectContactType::acceptableEnums()
        $projects = DB::connection('spider')->select("select * from `fq_provider_project_info`");
        foreach ($projects as $project) {
            $project_contact = $project->project_contact;
            dump($project_contact);
            $contacts = \GuzzleHttp\json_decode($project_contact, true);

            dump($project->id);

            if (!empty($contacts)) {
                foreach ($contacts as $contact) {
                    $type = $this->getProjectContactType($contact['section']);
                    if (!empty($contact['contact_list'])) {
                        foreach ($contact['contact_list'] as $item) {

                            dump($item);
                            $developer_project_contact_model = new DeveloperProjectContactModel();
                            $developer_project_contact_model->developer_project_id = $project->id;
                            $developer_project_contact_model->type = $type;
                            $developer_project_contact_model->sort = 0;
                            $developer_project_contact_model->company_name = $item['单位名称'];
                            $developer_project_contact_model->contact_name = $this->getContact($item['联系人']);
                            $developer_project_contact_model->job = $this->getJob($item['联系人']);
                            $developer_project_contact_model->address = $item['地址'];
                            $developer_project_contact_model->telphone = $item['电话'];
                            $developer_project_contact_model->mobile = $item['手机'];
                            $developer_project_contact_model->remark = '';

                            $developer_project_contact_model->save();
                        }
                    }
                }
            }
        }
    }


    public function getContact($str)
    {
        $contact = $str;
        $start_index = strpos($str, '( ');
        $end_index = strpos($str, ' )');
        if ($start_index !== false && $end_index != false) {
            $contact = substr($str, 0, $start_index);
        }
        dump(trim($contact));
        return trim($contact);
    }

    public function getJob($str)
    {
        $job = $str;
        $start_index = strpos($str, '( ');
        $end_index = strpos($str, ' )');
        if ($start_index !== false && $end_index != false) {
            $job = substr($str, $start_index + 1, $end_index - ($start_index + 1));
        }
        dump(trim($job));
        return trim($job);
    }


    /**
     * 得到项目联系人类型
     * @param $name
     * @return int
     */
    public function getProjectContactType($name)
    {
        $type = DeveloperProjectContactType::QT;
        if ($name == '业主单位') {
            $type = DeveloperProjectContactType::KFS;
        } else if ($name == '施工单位') {
            $type = DeveloperProjectContactType::JZDW;
        } else if ($name == '设计单位') {
            $type = DeveloperProjectContactType::SJY;
        }
        return $type;
    }


}
