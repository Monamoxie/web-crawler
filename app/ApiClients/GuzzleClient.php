<?php 

namespace App\ApiClients;

use App\Contracts\ClientInterface;
use GuzzleHttp\Client;

class GuzzleClient implements ClientInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $endpoint)
    {
        try {
            $response = $this->client->get($endpoint);
            $response_body = (string) $response->getBody();

            libxml_use_internal_errors(true);

            return $response_body;
        } catch (\Throwable $th) {
            return false;
        }
      
    }
  
    public function post()
    {

    }

    protected function authHeaders(): array
    {
        return [
            'Accept' => 'application/json'
        ];
    }
}