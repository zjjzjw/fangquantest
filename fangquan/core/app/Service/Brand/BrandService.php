<?php

namespace App\Service\Brand;


use App\Src\Brand\Infra\Repository\BrandCertificateRepository;
use App\Src\Brand\Infra\Repository\BrandCooperationRepository;
use App\Src\Brand\Infra\Repository\BrandCustomProductRepository;
use App\Src\Brand\Infra\Repository\BrandFactoryRepository;
use App\Src\Brand\Infra\Repository\BrandRepository;
use App\Src\Brand\Domain\Model\BrandEntity;
use App\Src\Brand\Domain\Model\BrandSpecification;
use App\Src\Brand\Infra\Repository\BrandSaleRepository;
use App\Src\Brand\Infra\Repository\BrandServiceRepository;
use App\Src\Brand\Infra\Repository\BrandSignListRepository;
use App\Src\Brand\Infra\Repository\BrandSupplementaryRepository;
use App\Src\Brand\Infra\Repository\SaleChannelRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class BrandService
{
    public function getProgress($brand_id)
    {
        $score = 20;
        $brand_progress = [];

        $brand_service_repository = new BrandServiceRepository();
        $brand_service_entity = $brand_service_repository->getBrandServiceByBrandId($brand_id);
        if (isset($brand_service_entity)) {
            $brand_progress['brand_service'] = true;
            $score += 10;
        }
        $brand_cooperation_repository = new BrandCooperationRepository();
        $brand_cooperation_entities = $brand_cooperation_repository->getBrandCooperationByBrandId($brand_id);
        if (!$brand_cooperation_entities->isEmpty()) {
            $brand_progress['brand_cooperation'] = true;
            $score += 10;
        }

        $brand_sign_list_repository = new BrandSignListRepository();
        $brand_sign_list_entities = $brand_sign_list_repository->getBrandSignListByBrandId($brand_id);
        if (!$brand_sign_list_entities->isEmpty()) {
            $brand_progress['brand_sign_list'] = true;
            $score += 10;
        }

        $brand_certificate_repository = new BrandCertificateRepository();
        $brand_certificate_entities = $brand_certificate_repository->getBrandCertificatesByBrandId($brand_id);
        if (!$brand_certificate_entities->isEmpty()) {
            $brand_progress['brand_certificate'] = true;
            $score += 10;
        }

        $brand_factory_repository = new BrandFactoryRepository();
        $brand_factory_entities = $brand_factory_repository->getBrandFactoriesByBrandId($brand_id);
        if (!$brand_factory_entities->isEmpty()) {
            $brand_progress['brand_factory'] = true;
            $score += 10;
        }

        $brand_sale_repository = new BrandSaleRepository();
        $brand_sale_entities = $brand_sale_repository->getBrandSalesByBrandId($brand_id);
        if (!$brand_sale_entities->isEmpty()) {
            $brand_progress['brand_sale'] = true;
            $score += 10;
        }

        $brand_custom_product_repository = new BrandCustomProductRepository();
        $brand_custom_product_entities = $brand_custom_product_repository->getBrandCustomProductsByBrandId($brand_id);
        if (!$brand_custom_product_entities->isEmpty()) {
            $brand_progress['brand_custom_product'] = true;
            $score += 10;
        }

        $sale_channel_repository = new SaleChannelRepository();
        $sale_channel_entities = $sale_channel_repository->getSaleChannelByBrandId($brand_id);
        if (!$sale_channel_entities->isEmpty()) {
            $brand_progress['brand_sale_channel'] = true;
            $score += 10;
        }

        $brand_supplementary_repository = new BrandSupplementaryRepository();
        $brand_supplementary_entities = $brand_supplementary_repository->getBrandSupplementaryByBrandId($brand_id);
        if (!$brand_supplementary_entities->isEmpty()) {
            $brand_progress['brand_supplementary'] = true;
        }

        $brand_progress['score'] = $score;

        return $brand_progress;
    }

}

