<?php


namespace App\Repositories;


use App\Http\Interfaces\PlantScheduleRepositoryInterface;
use App\Http\Interfaces\PostRepositoryInterface;
use App\Models\PlantSchedule;
use App\Models\Post;

class PlantScheduleRepo extends  Repository implements PlantScheduleRepositoryInterface
{
    protected  $model;
    public function __construct(PlantSchedule $model)
    {
        $this->model=$model;
    }

}
