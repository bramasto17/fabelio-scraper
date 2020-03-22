<?php

namespace App\Services;

use App\Models\Products;
use App\Models\ProductGalleries;
use App\Models\PriceHistories;
use App\Services\ScrapeService;

class ProductsService extends \App\Services\BaseService
{
    private $scrapeService;
    public function __construct(ScrapeService $scrapeService) {
        $this->scrapeService = $scrapeService;
    }

    public function submit(array $data)
    {
        $data = $this->scrapeService->scrape($data['url']);
        // dd($data);

        return $this->atomic(function() use ($data) {
            // Create Product Data
            $product = $this->createProduct(array_except($data,['product_gallery']));
            // dd($product);

            // Create Product Gallery
            $productGallery = $this->createProductGallery($data['product_gallery'], $product['id']);

            // Create Price History
            $priceHistory = $this->createPriceHistory($data, $product['id']);

            return $product;
        });

    }

    protected function createProduct(array $data)
    {
        return $this->atomic(function() use ($data) {
            $result = Products::create($data)->toArray();

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
}
