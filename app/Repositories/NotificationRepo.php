<?php


namespace App\Repositories;


use App\Http\Interfaces\NotificationRepositoryInterface;

use App\Models\Notification;


class NotificationRepo extends  Repository implements NotificationRepositoryInterface
{
    protected  $model;
    public function __construct(Notification $model)
    {
        $this->model=$model;
    }

}
