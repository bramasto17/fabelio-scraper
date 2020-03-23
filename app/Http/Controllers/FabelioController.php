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
        return view('fabelio.submit');
    }

    public function submit(Request $request)
    {
        $attributes = array_except($request->all(),['_token']);
        $result = $this->productsService->submit($attributes);

        if(!@$result){
            \Session::flash('flash_message', 'URL Invalid!');
            return redirect('/');
        }

        return redirect('/products/'.$result['id']);
    }

    public function showProducts(Request $request)
    {
        $attributes = $request->all();
        $results = $this->productsService->getAll($attributes);
    	dd($results);

        return view('fabelio.products.submit');
    }

    public function showProductById($id)
    {
        $result = $this->productsService->getById($id);
        // dd($result);
        
        return view('fabelio.detail', compact('result'));
    }

    public function getProductById($id)
    {
        $result = $this->productsService->getById($id);
        
        return $result;
    }
}
