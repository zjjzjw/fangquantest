<?php

namespace App\Console\Commands\Provider;

use App\Service\Provider\ProviderService;
use App\Service\Push\PushService;
use App\Src\Provider\Domain\Model\ProviderCertificateStatus;
use App\Src\Provider\Domain\Model\ProviderCertificateType;
use App\Src\Provider\Domain\Model\ProviderServiceNetworkStatus;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Provider\Infra\Repository\ProviderCertificateRepository;
use App\Src\Provider\Infra\Repository\ProviderServiceNetworkRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class CalculateProviderScore extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:provider:score';

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
        $provider_models = ProviderModel::all();
        foreach ($provider_models as $provider_model) {

            $provider_model->score_scale = $this->getScaleScore($provider_model);
            $provider_model->score_qualification = $this->getQualificationScore($provider_model);
            $provider_model->score_credit = $this->getCreditScore($provider_model);
            $provider_model->score_innovation = $this->getInnovationScore($provider_model);
            $provider_model->score_service = $this->getServiceScore($provider_model);

            $provider_model->save();

            $this->info($provider_model->id . '计算完成！');
        }
    }


    //企业规模
    public function getScaleScore($provider_model)
    {
        $score = 0;
        if ($provider_model->worker_count < 5) {
            $score = 50;
        }
        if ($provider_model->worker_count >= 5 && $provider_model->worker_count < 50) {
            $score = 60;
        }
        if ($provider_model->worker_count >= 50 && $provider_model->worker_count < 100) {
            $score = 70;
        }
        if ($provider_model->worker_count >= 100 && $provider_model->worker_count < 500) {
            $score = 80;
        }
        if ($provider_model->worker_count >= 500 && $provider_model->worker_count < 1000) {
            $score = 90;
        }
        if ($provider_model->worker_count > 1000) {
            $score = 100;
        }
        return intval($score);
    }

    //行业资质
    public function getQualificationScore($provider_model)
    {
        $score = 40;
        $provider_certificate_repository = new ProviderCertificateRepository();
        $provider_certificate_entities = $provider_certificate_repository->getProviderCertificateByProviderIdAndStatus(
            $provider_model->id, ProviderCertificateStatus::STATUS_PASS,
            ProviderCertificateType::QUALIFICATION
        );
        $number = $provider_certificate_entities->count();
        $score += ($number / 2) * 10;

        return $score;
    }

    //企业信用
    public function getCreditScore($provider_model)
    {
        $score = 100;
        return intval($score);
    }

    //创新能力
    public function getInnovationScore($provider_model)
    {
        $score = 30;
        $provider_certificate_repository = new ProviderCertificateRepository();
        $provider_certificate_entities = $provider_certificate_repository->getProviderCertificateByProviderIdAndStatus(
            $provider_model->id, ProviderCertificateStatus::STATUS_PASS,
            ProviderCertificateType::PATENT
        );
        $number = $provider_certificate_entities->count();
        $score += ($number / 2) * 10;

        return intval($score);
    }

    //服务体系
    public function getServiceScore($provider_model)
    {
        $score = 30;
        $provider_service_network_repository = new ProviderServiceNetworkRepository();
        $provider_service_network_entities =
            $provider_service_network_repository->getProviderServiceNetworkByProviderIdAndStatus(
                $provider_model->id, ProviderServiceNetworkStatus::STATUS_PASS
            );
        $number = $provider_service_network_entities->count();
        $score += ($number / 2) * 10;

        return intval($score);
    }

}
