<?php


namespace App\Repositories;
use App\Http\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepo extends  Repository implements PostRepositoryInterface
{
    protected  $model;
    public function __construct(Post $model)
    {
        $this->model=$model;
    }

}
