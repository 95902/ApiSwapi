<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class StarWarsApiService
{
    private const SWAPI_URL = 'https://swapi.py4e.com/api/people/';
    private const ITEM ='ITEM';
    private const COLLECTION = 'COLLECTION';


    public function __construct(private readonly HttpClientInterface $httpClient)
    {

    }

    public function getPersonage(int $id): array
    {
        return $this->makeRequest(self::ITEM, $id);
    }

    public function getPersonages(): array
    {
        return $this->makeRequest(self::COLLECTION, null);
    }


    private function makeRequest(string $type, ?int $id): array
    {
        $url = $id ? self::SWAPI_URL . $id : self::SWAPI_URL;
        $response = $this->httpClient->request('GET', $url);
        $data = match ($type) {
            self::ITEM => $response->toArray(),
            self::COLLECTION => $response->toArray()['results'],
        };
        return $data;
    }
}