<?php


namespace App\Service\Weather\OpenWeatherMap;


use GuzzleHttp\Client;

class ApiClient
{

    private Client $client;

    private string $apiKey;

    private string $url;

    public function __construct()
    {
        $this->apiKey = config('openweathermap.apikey');
        $this->url = config('openweathermap.url');
        $this->client = new Client();
    }

    /**
     * @param string $url
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeRequest(string $url, array $params = [])
    {
        $appid = ['appid' => $this->apiKey];
        return $this->client->get($this->url . $url, ['query' => $params + $appid]);
    }

    public function getTemperature(string $query)
    {
        return $this->makeRequest('/weather', ['q' => $query]);
    }

}
