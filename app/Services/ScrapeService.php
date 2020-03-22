<?php

namespace App\Services;

class ScrapeService extends \App\Services\BaseService
{
    public function scrape($url)
    {
        try{
            // Parse HTML
            $html = $this->call('GET',$url,[],null,false);

            // Get Product Id from HTML
            $productId = $this->getStringBetween($html, "dataProductIdSelector = '[data-product-id=", ']');

            // Get Product Desc from HTML
            $description = strip_tags($this->getStringBetween($html, "<div id=\"description\">", '</div>'));

            // Get Product Data (Name, Price, Image) from API
            $productData = $this->call('GET','https://fabelio.com/insider/data/product/id/'.$productId);
            $name = $productData['product']['name'];
            $regular_price = $productData['product']['unit_price'];
            $final_price = $productData['product']['unit_sale_price'];
            $product_image_url = $productData['product']['product_image_url'];

            // Get Product Images from API
            $product_gallery = [];
            $productGallery = $this->call('GET','https://fabelio.com/swatches/ajax/media/?product_id='.$productId);
            foreach ($productGallery['gallery'] as $key => $gallery) {
                $product_gallery[]['image_url'] = $gallery['medium'];
            }

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
            abort(400, 'URL Invalid');
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
