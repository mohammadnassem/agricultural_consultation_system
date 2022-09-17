<?php


namespace App\Repositories;



use App\Http\Interfaces\StageRepositoryInterface;
use App\Models\Stage;

class StageRepo  extends  Repository implements StageRepositoryInterface
{
    protected  $model;
    public function __construct(Stage $model)
    {
        $this->model=$model;
    }

}
