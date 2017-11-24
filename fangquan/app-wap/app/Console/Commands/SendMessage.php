<?php

namespace App\Wap\Console\Commands;

use App\Service\Push\PushService;
use App\Wap\Service\Weixin\WeixinService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class SendMessage extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message';

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
        $weixin_service = new  WeixinService();

        dump($weixin_service->setMenu());


    }
}
