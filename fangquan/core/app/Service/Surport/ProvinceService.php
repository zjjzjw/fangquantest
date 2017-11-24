<?php namespace App\Service\Surport;


use App\Src\Surport\Infra\Eloquent\CityModel;
use App\Src\Surport\Infra\Eloquent\ProvinceModel;
use App\Src\Surport\Infra\Repository\CityRepository;
use App\Src\Surport\Infra\Repository\ProvinceRepository;

class ProvinceService
{
    public function getProvinceForSearch()
    {
        $rows = [];
        $province_repository = new ProvinceRepository();
        $province_models = $province_repository->all();
        $provinces = [];
        /** @var ProvinceModel $province_model */
        foreach ($province_models as $province_model) {
            $provinces[] = $province_model->toArray();
        }
        $city_repository = new CityRepository();
        $city_models = $city_repository->all();
        $cities = [];
        /** @var CityModel $city_model */
        foreach ($city_models as $city_model) {
            $cities[] = $city_model->toArray();
        }
        foreach ($provinces as &$province) {
            $province['nodes'] = collect($cities)->where('province_id', $province['id'])->toArray();
            $rows[] = $province;
        }

        return $rows;
    }


    public function getServiceCities()
    {
        $items = [];
        $city_repository = new CityRepository();
        $city_models = $city_repository->all();
        foreach ($city_models as $city_model) {
            $items[$city_model->name] = [$city_model->lng, $city_model->lat];
        }

        return $items;
    }
}