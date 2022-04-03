<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        $element = $this->model->find($id);
        if ($element == null) 
        {
            throw new ModelNotFoundException("Model not found");
        }

        return $element;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}