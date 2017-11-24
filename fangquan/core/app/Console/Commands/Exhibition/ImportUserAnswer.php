<?php

namespace App\Console\Commands\Exhibition;

use App\Src\Content\Domain\Model\UserInfoEntity;
use App\Src\Content\Infra\Repository\UserAnswerRepository;
use App\Src\Content\Infra\Repository\UserInfoRepository;
use App\Src\FqUser\Domain\Model\FqUserEntity;
use App\Src\FqUser\Domain\Model\FqUserRoleType;
use App\Src\FqUser\Infra\Repository\FqUserRepository;
use Illuminate\Console\Command;

class ImportUserAnswer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:userAnswer';

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
        $data[] = ['姓名', '类型', '公司', '职位', '电话', '邮箱', '问题答案', '对接人姓名', '电话', '职位', '不参加原因'];
        $time = '2017-11-10 23:00:00';
        $user_info_repository = new UserInfoRepository();
        $user_answer_repository = new UserAnswerRepository();
        $fq_user_repository = new FqUserRepository();
        $fq_user_role_type = FqUserRoleType::acceptableEnums();
        $user_info_entities = $user_info_repository->all();
        /** @var UserInfoEntity $user_info_entity */
        foreach ($user_info_entities as $user_info_entity) {
            //$item = $user_info_entity->toArray();
            $user_answer_entity = $user_answer_repository->getUserAnswerByUserId($user_info_entity->user_id, $time);
            if (!isset($user_answer_entity)) {
                continue;
            }
            $fq_type = '';
            /** @var FqUserEntity $fq_user_entity */
            $fq_user_entity = $fq_user_repository->fetch($user_info_entity->user_id);
            if (isset($fq_user_entity)) {
                $fq_type = $fq_user_role_type[$fq_user_entity->role_type] ?? '';
            }
            $user_answer = '';
            $user_info_name = '';
            $user_info_phone = '';
            $user_info_job = '';
            $user_info_reason = '';
            $user_answer_data = [];
            if (isset($user_answer_entity)) {
                $user_answer = json_decode($user_answer_entity->answer);
                foreach ($user_answer as $key => $value) {
                    if ($key < count($user_answer) - 1) {
                        if (!is_array($value[0])){
                            $user_answer_data[] = ($key + 1) . '.' . implode(',', $value);
                        }
                    }
                    foreach ($value as $k => $item) {
                        if (is_array($item)) {
                            $user_info_name = $item[0]->name;
                            $user_info_phone = $item[1]->phone;
                            $user_info_job = $item[2]->job;
                            $user_info_reason = $item[3]->reason;
                        }
                    }
                }
            }
            $data[] = [$user_info_entity->name, $fq_type, $user_info_entity->company, $user_info_entity->position, $user_info_entity->phone, $user_info_entity->email, implode(',', $user_answer_data), $user_info_name, $user_info_phone, $user_info_job, $user_info_reason];
        }
        \Excel::create('问卷调查', function ($excel) use ($data) {
            $excel->sheet('score', function ($sheet) use ($data) {
                $sheet->rows($data);
            });
        })->store('xls');
        $this->info('导入结束');
    }
}
