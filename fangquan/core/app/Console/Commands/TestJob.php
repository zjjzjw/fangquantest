<?php

namespace App\Console\Commands;

use App\Service\Push\PushService;
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
        \Log::info("测试JOB 每分钟执行一次");
        //$this->line('测试JOB');
        //$push_service = new PushService();
        //$reg_ids = [];
        //$reg_ids[] = 'hW6KVNLJK4yYQ9qnGSTn0L5G+m0Fdd+eOcLUAAQ3Bv4=';
        //$title = "88888888";
        //$push_service->pushIOSMessage($reg_ids, $title);
    }
}
