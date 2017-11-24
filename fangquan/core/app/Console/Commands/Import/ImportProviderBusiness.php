<?php

namespace App\Console\Commands\Import;

use App\Foundation\Domain\Exceptions\Exception;
use App\Src\Provider\Domain\Model\ProviderNewsStatus;
use App\Src\Provider\Infra\Eloquent\ProviderBusinessModel;
use App\Src\Provider\Infra\Eloquent\ProviderNewsModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProviderBusiness extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:provider:business';

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
        $provider_businesses = DB::connection('spider')->select("select * from `tyc_supplier100_info`");

        foreach ($provider_businesses as $provider_business) {
            try {

                $provider_business_model = ProviderBusinessModel::where('provider_id', $provider_business->provider_id)
                    ->first();
                if (!isset($provider_business_model)) {
                    $provider_business_model = new ProviderBusinessModel();
                }
                $provider_business_model->provider_id = $provider_business->provider_id;
                $provider_business_model->base_info = $provider_business->base_info;
                $provider_business_model->main_person = $provider_business->main_person;
                $provider_business_model->shareholder_info = $provider_business->shareholder_info;
                $provider_business_model->change_record = $provider_business->change_record;
                $provider_business_model->branchs = $provider_business->branchs;
                $provider_business_model->financing_history = $provider_business->financing_history;
                $provider_business_model->core_team = $provider_business->core_team;
                $provider_business_model->enterprise_business = $provider_business->enterprise_business;
                $provider_business_model->legal_proceedings = $provider_business->legal_proceedings;
                $provider_business_model->legal_proceedings = '[]';
                $provider_business_model->court_notice = $provider_business->court_notice;
                $provider_business_model->dishonest_person = $provider_business->dishonest_person;
                $provider_business_model->person_subjected_execution = $provider_business->person_subjected_execution;
                $provider_business_model->abnormal_operation = $provider_business->abnormal_operation;
                $provider_business_model->administrative_sanction = $provider_business->administrative_sanction;
                $provider_business_model->serious_violation = $provider_business->serious_violation;
                $provider_business_model->stock_ownership = $provider_business->stock_ownership;
                $provider_business_model->chattel_mortgage = $provider_business->chattel_mortgage;
                $provider_business_model->tax_notice = $provider_business->tax_notice;
                $provider_business_model->bidding = $provider_business->bidding;;
                $provider_business_model->purchase_information = $provider_business->purchase_information;
                $provider_business_model->tax_rating = $provider_business->tax_rating;
                $provider_business_model->qualification_certificate = $provider_business->qualification_certificate;
                $provider_business_model->trademark_information = $provider_business->trademark_information;
                $provider_business_model->patent = $provider_business->patent;

                $provider_business_model->save();

                $this->info($provider_business->provider_id . '导入完成！');
            } catch (Exception $ex) {
                $this->error($provider_business->provider_id, '导入失败');
            }
        }
    }
}
