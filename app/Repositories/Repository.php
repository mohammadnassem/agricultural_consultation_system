<?php


namespace App\Repositories;
use \App\Http\Interfaces\RepositoryInterface;

use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;


class Repository implements RepositoryInterface
{

    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();

    }

    public function create(array $data)
    {
        try {
            return $this->model->create($data);

        }catch (\Exception $e){

           return null;
        }

    }

    public function update(array $data, $id)
    {
        try {
            $record = $this->model->find($id);
            if($record != null)
            return $record->update($data);

        }catch (Exception $e){
            return null;
        }

    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function show($id)
    {
        return $this->model-findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public  function  getOne($id){
        return $this->model->find($id);

    }


}
