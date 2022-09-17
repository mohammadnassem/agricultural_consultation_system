<?php


namespace App\Repositories;


use App\Http\Interfaces\DiseasesRepositoryInterface;
use App\Models\Disease;


class DiseasesRepo extends  Repository implements DiseasesRepositoryInterface
{
    protected  $model;
    public function __construct(Disease $model)
    {
        $this->model=$model;
    }

}
