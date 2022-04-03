<?php

namespace App\Repositories\Interfaces;


interface BaseRepositoryInterface
{
    public function delete($id);

    public function find($id);
}