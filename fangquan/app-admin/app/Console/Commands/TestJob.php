<?php

namespace App\Admin\Console\Commands;

use App\Service\Push\PushService;
use App\Src\FqUser\Infra\Eloquent\FqUserModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class TestJob extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('测试JOB');
        /*
        $push_service = new PushService();
        $reg_ids = [];
        $reg_ids[] = 'hW6KVNLJK4yYQ9qnGSTn0L5G+m0Fdd+eOcLUAAQ3Bv4=';
        $title = "88888888";
        $push_service->pushIOSMessage($reg_ids, $title);
        */
        $builder = FqUserModel::query();
        $builder->where('id', '>', 0);
        $builder->whereRaw('  ( case when   platform_id = 3  then role_type  = 2  
                                     when   platform_id = 1  then role_type  = 1 end ) ');

        dd($builder->toSql());

    }
}
