<?php

namespace App\Http\Controllers;

use App\Services\ProductsService;

use Illuminate\Http\Request;

class FabelioController extends Controller
{
    private $productsService;

    public function __construct(ProductsService $productsService) {
        $this->productsService = $productsService;    
    }

    public function showSubmit()
    {
    	// dd('showSubmit');
        return view('fabelio.submit');
    }

    public function showProducts()
    {
    	dd('showProducts');
        return view('fabelio.products.submit');
    }

    public function showProductById($id)
    {
    	dd('showProduct'.$id);
        return view('fabelio.products.submit');
    }

    public function submit(Request $request)
    {
        $attributes = $request->all();
        $result = $this->productsService->submit($attributes);

        // \Session::flash('flash_message', 'Department successfully Created!');
    	dd('create');
        return redirect('products');
    }

    // public function getAll(Request $request)
    // {
    //     $attributes = $request->all();
    //     $results = $this->productsService->getAll($attributes);
    //     dd($results);

    //     // return view('hrms.products.list', compact('results'));
    // }

    // public function add()
    // {
    // 	dd('add');
    //     return view('hrms.products.add');
    // }

    // public function create(Request $request)
    // {
    //     $attributes = $request->all();
    //     $result = $this->productsService->create($attributes);

    //     // \Session::flash('flash_message', 'Department successfully Created!');
    // 	dd('create');
    //     return redirect('products');
    // }

    // public function edit($id)
    // {
    //     $result = $this->productsService->getById($id);

    //     return view('hrms.products.edit', compact('result'));
    // }

    // public function update(Request $request, $id){
    //     $attributes = array_except($request->all(), ['_token']);
    //     $result = $this->productsService->update($attributes, $id);

    //     \Session::flash('flash_message', 'Department successfully Updated!');
    //     return redirect('products');
    // }

    // public function delete($id)
    // {
    //     $this->productsService->delete($id);

    //     \Session::flash('flash_message', 'Department successfully Deleted!');
    //     return redirect('products');
    // }
}
