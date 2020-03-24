<?php

namespace App\Services;

use Closure;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected $request;

    protected function atomic(Closure $callback)
    {
        return \DB::transaction($callback);
    }

    protected function dataWrapper($data)
    {
        $results = [];

        $results['data'] = $data['data'];

        unset($data['data']);

        $results['meta'] = $data;

        return $results;
    }

    protected function queryBuilder($baseQuery, $attributes, $includes = [])
    {
        if (is_string($baseQuery)) {
            $baseQuery = ($baseQuery)::query();
        }

        $sort = (@$attributes['sort']) ? $attributes['sort'] : null;
        $sortRule = (@$attributes['sort_rule']) ? $attributes['sort_rule'] : null;

        $baseQuery = $baseQuery->with($includes);

        if (!is_null($sort))
            $baseQuery = $baseQuery->orderBy($sort, $sortRule);

        return $baseQuery;
    }

    protected function call($method, $url, $data = [], $token = null, $api = true)
    {
        $headers = [
            'Authorization' => $token,
            'Accept'        => 'application/json'
        ];

        $client = new \GuzzleHttp\Client();

        if ($method == 'GET') {
            $parameters = [
                'headers' => $headers
            ];
        } else {
            $parameters = [
                'headers'     => $headers,
                'form_params' => $data
            ];
        }

        try {
            $response = $client->request($method, $url, $parameters);

            if($api){
                return json_decode($response->getBody(), true);
            }
            else{
                return $response->getBody()->getContents();
            }
        } catch (\Exception $e) {
            $error = [
                'origin' => $url,
                'response' => json_decode($e->getResponse()->getBody()->getContents(), true)
            ];

            if ($e->getResponse()->getStatusCode() == 404) {
                return null;
            } else return abort($error['response']['status'], $url . ' : ' . $error['response']['message']);
        }
    }



}