<?php

namespace App\Services;

use App\Models\Products;

class ProductsService extends \App\Services\BaseService
{
    public function submit(array $data)
    {
        dd($data);
        return $this->atomic(function() use ($data) {
            $result = Products::create($data)->toArray();

            return $result;
        });
    }
    
    // private $departmentsService;
    // public function __construct(DepartmentsService $departmentsService) {
    //     $this->departmentsService = $departmentsService;
    // }

    // public function getAll($attributes = [])
    // {
    //     $results = $this->queryBuilder(Products::class, $attributes, ['department'])->get()->toArray();

    //     return $results;
    // }

    // public function getById($id)
    // {
    //     $result = Products::where('id', $id)->firstOrFail()->toArray();

    //     return $result;
    // }

    

    // public function update(array $data, $id)
    // {
    // 	return $this->atomic(function() use ($data, $id) {
	   //      Products::where('id', $id)->update($data);

	   //      $result = Products::where('id', $id)->firstOrFail()->toArray();

	   //      return $result;
    // 	});
    // }

    // public function delete($id)
    // {
    //     Products::where('id', $id)->delete();
    // }

    // public function getDepartments()
    // {
    //     return $this->departmentsService->getAll(null);
    // }
}
