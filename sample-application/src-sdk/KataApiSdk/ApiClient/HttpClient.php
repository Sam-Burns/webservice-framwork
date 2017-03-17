<?php
namespace KataApiSdk\ApiClient;

use GuzzleHttp\Client as GuzzleClient;
use KataApiSdk\ApiClient;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements ApiClient
{
    private $guzzleClient;
    private $hostname;
    private $port;

    public function __construct(GuzzleClient $guzzleClient, $hostname, $port)
    {
        $this->guzzleClient = $guzzleClient;
        $this->hostname = $hostname;
        $this->port = $port;
    }

    public function varDumpThisForMe(string $path, string $method = 'GET')
    {
        $response = $this->doRequest($path, $method);
        var_dump($response->getStatusCode(), $response->getBody()->getContents());
        exit;
    }

    public function request(string $path, string $method) : array
    {
        $response = $this->doRequest($path, $method);
        return $this->decodeResponse($response);
    }

    private function doRequest(string $path, string $method) : ResponseInterface
    {
        $requestUri = 'http://' . $this->hostname . ':' . $this->port . '/' . $path;
        $method = strtolower($method);
        $response = $this->guzzleClient->$method($requestUri);
        return $response;
    }

    private function decodeResponse(ResponseInterface $response) : array
    {
        $responseBody = $response->getBody()->getContents();
        $decodedResponseBody = json_decode($responseBody, true);
        return $decodedResponseBody;
    }
}
