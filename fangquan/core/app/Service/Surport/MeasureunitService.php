<?php namespace App\Service\Surport;

use App\Src\Provider\Infra\Repository\MeasureunitRepository;
use App\Src\Provider\Infra\Eloquent\MeasureunitModel;

class MeasureunitService
{
    public function getMeasureunitForSelect()
    {
        $measureunits = [];
        $measureunit_repository = new MeasureunitRepository();
        $measureunit_models = $measureunit_repository->all();

        /** @var MeasureunitModel $measureunit_model */
        foreach ($measureunit_models as $measureunit_model) {
            $measureunits[] = $measureunit_model->toArray();
        }

        return $measureunits;
    }

}