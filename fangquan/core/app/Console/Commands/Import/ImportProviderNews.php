<?php

namespace App\Console\Commands\Import;

use App\Src\Provider\Domain\Model\ProviderNewsStatus;
use App\Src\Provider\Infra\Eloquent\ProviderNewsModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProviderNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:provider:news';

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
        $provider_news = DB::connection('spider')->select("select * from `fortune100_supplier_news`");
        foreach ($provider_news as $provider_new) {
            $provider_news_model = new ProviderNewsModel();
            $provider_news_model->provider_id = $provider_new->provider_id;
            $provider_news_model->title = $provider_new->title;
            $provider_news_model->content = $provider_new->news_info;
            $provider_news_model->status = ProviderNewsStatus::STATUS_PASS;
            $provider_news_model->save();
        }
        $this->info('结束');
    }
}
