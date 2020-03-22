<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class UpdateAllProducts extends Command
{
    private $productsService;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "product:update";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update all produts data";

    public function __construct(\App\Services\ProductsService $productsService)
    {
        parent::__construct();
        $this->productsService = $productsService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->productsService->updateAllProducts();
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}