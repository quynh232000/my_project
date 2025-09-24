<?php

namespace App\Services;

class ElasticSearchServiceq
{

    protected $client;

    public function __construct()
    {
        $this->client = \Elastic\Elasticsearch\ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST', 'http://localhost:9200')])
            ->build();
    }

    public function search($index, $query)
    {
        return $this->client->search([
            'index' => $index,
            'body'  => ['query' => ['match' => ['content' => $query]]]
        ]);
    }
}
