<?php

namespace App\Services;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use InvalidArgumentException;

trait ElasticSearchService
{
    /**
     * Initializes and returns an Elasticsearch client.
     *
     * @return \Elasticsearch\Client
     */
    public function initElasticConnection(): Client
    {
        return ClientBuilder::create()
            ->setHosts([$this->getConfig('hosts')])
            // ->setApiKey($this->getConfig('ApiKey'))
            // ->setCABundle($this->getConfig('CA'))
            ->setBasicAuthentication($this->getConfig('username'), $this->getConfig('password'))
            ->build();
    }

    /**
     * Initialization for each set of indexing
     *
     */
    public function create_new_index(string $indexName, array $settings = [])
    {
        $client = $this->initElasticConnection();

        // $indices = $client->indices()->exists(['index' => $indexName]);
        // if ($indices) {
        //     return "index '{$indexName}' meow is already exists.";
        // }
        // return $indices;

        $params = [
            'index' => $indexName,
            'body' => $settings
        ];

        try {
            //code...
            $client->indices()->create($params);
            return "Index '{$indexName}' created successfully.";
        } catch (\Exception $e) {
            //throw $th;
            throw new \RuntimeException("Failed to create index '{$indexName}': " . $e->getMessage());
        }

        // throw new Exceptions("You need to create index first, use elastic:* command");
    }

    public function delete_specific_indexing($index_name)
    {
        $client = $this->initElasticConnection();

        $params = ['index' => $index_name];
        try {
            $client->indices()->delete($params);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to delete index '{$index_name}': " . $e->getMessage());
        }
    }

    /**
     * Default mapping will be automatically follow data type that we'll have already passed in
     *
     */
    public function explicit_mapping(string $indexName, array $mappings)
    {
        $client = $this->initElasticConnection();

        $params = [
            'index' => $indexName,
            'body' => [
                'properties' => $mappings
            ]
        ];

        try {
            //code...
            $client->indices()->putMapping($params);
            return "Mapping applied successfully to index '{$indexName}'.";
        } catch (\Exception $e) {
            //throw $th;
            throw new \RuntimeException("Failed to create index '{$indexName}': " . $e->getMessage());
        }
        // }
        // throw new Exceptions("You need to create index first, use elastic:* command");
    }

    /**
     * Fetches Elasticsearch configuration values.
     *
     * @param string $key
     * @return mixed
     */
    protected function getConfig(string $key)
    {
        $config = config('services.elasticsearch');
        if (!isset($config[$key])) {
            throw new InvalidArgumentException("Missing ElasticSearch configuration key: $key");
        }
        return $config[$key];
    }
}
