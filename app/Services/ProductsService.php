<?php

namespace App\Services;

use App\Models\Products;
use App\Models\ProductGalleries;
use App\Models\PriceHistories;
use App\Services\ScrapeService;
use Carbon\Carbon;

class ProductsService extends \App\Services\BaseService
{
    private $scrapeService;
    private $include = ['priceHistory','gallery'];

    public function __construct(ScrapeService $scrapeService) {
        $this->scrapeService = $scrapeService;
    }

    public function getAll($attributes = [])
    {
        $results = $this->queryBuilder(Products::class, $attributes, [])->get()->toArray();

        return $results;
    }

    public function getById($id)
    {
        $result = Products::with($this->include)->where('id', $id)->firstOrFail()->toArray();

        return $result;
    }

    public function submit(array $data)
    {
        $data = $this->scrapeService->scrape($data['url']);

        if(@$data){
            return $this->atomic(function() use ($data) {
                $product = Products::where('fabelio_product_id',$data['fabelio_product_id'])->first();
                // If product already exists
                if(@$product){
                    $product = $product->toArray();

                    // Only update data if it's at different hour than the last update
                    if(date('H', strtotime($product['updated_at'])) != date('H', strtotime(Carbon::now()->setTimezone('Asia/Jakarta')))){
                        $product = $this->updateProduct(array_except($data,['product_gallery']));

                        $priceHistory = $this->createPriceHistory($data, $product['id']);    
                    }
                }
                // If product does not exist yet
                else{
                    // Create Product Data
                    $product = $this->createProduct(array_except($data,['product_gallery']));

                    // Create Product Gallery
                    $productGallery = $this->createProductGallery($data['product_gallery'], $product['id']);

                    // Create Price History
                    $priceHistory = $this->createPriceHistory($data, $product['id']);
                }

                return $product;
            });
        }
        else{
            return null;
        }
    }

    protected function createProduct(array $data)
    {
        return $this->atomic(function() use ($data) {
            $result = Products::create($data)->toArray();

            return $result;
        });
    }

    protected function updateProduct(array $data)
    {
        return $this->atomic(function() use ($data) {
            Products::where('fabelio_product_id',$data['fabelio_product_id'])->update($data);

            $result = Products::where('fabelio_product_id',$data['fabelio_product_id'])->first()->toArray();

            return $result;
        });
    }

    protected function createProductGallery(array $data, $productId)
    {
        return $this->atomic(function() use ($data, $productId) {
            $results = [];

            foreach ($data as $value) {
                $value['product_id'] = $productId;
                $results[] = ProductGalleries::create($value)->toArray();
            }

            return $results;
        });
    }

    protected function createPriceHistory(array $data, $productId)
    {
        return $this->atomic(function() use ($data, $productId) {
            $data = [
                'product_id' => $productId,
                'final_price' => $data['final_price'],
                'regular_price' => $data['regular_price'],
            ];

            $result = PriceHistories::create($data)->toArray();

            return $result;
        });
    }

    public function updateAllProducts()
    {
        $products = Products::all()->toArray();
        foreach ($products as $product) {
            $url = $product['product_url'];
            $this->submit(['url' => $url]);
        }
    }
}
