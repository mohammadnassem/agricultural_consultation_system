<?php


namespace App\Repositories;


use App\Http\Interfaces\CommentRepositoryInterface;
use App\Http\Interfaces\PlantRepositoryInterface;
use App\Models\Comment;
use App\Models\Plant;

class CommentRepo extends  Repository implements CommentRepositoryInterface
{
    protected  $model;
    public function __construct(Comment $model)
    {
        $this->model=$model;
    }

}
