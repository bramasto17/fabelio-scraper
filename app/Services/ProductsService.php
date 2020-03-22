<?php

namespace App\Services;

use App\Models\Products;
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
        dd($data);
    }

    public function create(array $data)
    {
        return $this->atomic(function() use ($data) {
            $result = Products::create($data)->toArray();

            return $result;
        });
    }
}
