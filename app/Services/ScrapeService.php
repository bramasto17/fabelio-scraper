<?php

namespace App\Services;

class ScrapeService extends \App\Services\BaseService
{
    public function scrape($url)
    {
        try{
            // Parse HTML
            // Get html file to be parsed from the given url
            $html = $this->call('GET',$url,[],null,false);

            // Get Product Id from HTML
            // Inside I parse the html and find the product id
            $productId = $this->getStringBetween($html, "dataProductIdSelector = '[data-product-id=", ']');

            // Get Product Data (Name, Price, Image) from API
            // When exploring the html, I notice an API call via AJAX to get product detail, and I figured instead of obtain the data from parsing the html, I prefer to call the API and get the data I want
            $productData = $this->call('GET','https://fabelio.com/insider/data/product/id/'.$productId);
            $name = $productData['product']['name'];
            $regular_price = $productData['product']['unit_price'];
            $final_price = $productData['product']['unit_sale_price'];
            $product_image_url = $productData['product']['product_image_url'];

            // Get Product Images from API
            // This works the same like the previous
            $product_gallery = [];
            $productGallery = $this->call('GET','https://fabelio.com/swatches/ajax/media/?product_id='.$productId);
            foreach ($productGallery['gallery'] as $key => $gallery) {
                $product_gallery[]['image_url'] = $gallery['medium'];
            }

            // Get Product Desc from HTML
            // I notice I can't get the product description from the API, so I parse the html again to get it
            $description = strip_tags($this->getStringBetween($html, "<div id=\"description\">", '</div>'));

            return [
                'fabelio_product_id' => $productId,
                'name' => $name,
                'description' => $description,
                'regular_price' => $regular_price,
                'final_price' => $final_price,
                'product_url' => $url,
                'product_image_url' => $product_image_url,
                'product_gallery' => $product_gallery
            ];
        } catch (\Exception $e) {
            
        }
    }

    protected function getStringBetween($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
