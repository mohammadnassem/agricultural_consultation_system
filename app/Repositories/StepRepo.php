<?php


namespace App\Repositories;


use App\Http\Interfaces\StageRepositoryInterface;
use App\Http\Interfaces\StepRepositoryInterface;
use App\Models\Stage;
use App\Models\Step;

class StepRepo  extends  Repository implements StepRepositoryInterface
{
    protected  $model;
    public function __construct(Step $model)
    {
        $this->model=$model;
    }

}
