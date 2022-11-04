<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiServiceGPS
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }



    public function getFranceApi($val): array
    {   
        $response = $this->client->request(
            'GET',
            'https://api-adresse.data.gouv.fr/search/?q='.$val
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray()['features'][0];
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        $coordinates = $content['geometry']['coordinates'];

        return $coordinates;
    }
}






?>