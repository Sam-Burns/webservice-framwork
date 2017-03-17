<?php
namespace KataApiSdk\ApiClient;

use Psr\Container\ContainerInterface;
use KataApi\Application\Application;
use KataApiSdk\ApiClient;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequest;

class ApplicationTestClient implements ApiClient
{
    /** @var Application */
    private $application;

    /** @var ContainerInterface */
    private $container;

    public function __construct(Application $application, ContainerInterface $container)
    {
        $this->application = $application;
        $this->container = $container;
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
        $requestUri = 'http://localhost:8001/' . $path;
        $request = new ServerRequest([], [], $requestUri, $method);
        $response = $this->application->runAgainstRequest($request);
        return $response;
    }

    private function decodeResponse(ResponseInterface $response) : array
    {
        $response->getBody()->rewind();
        $responseBody = $response->getBody()->getContents();

        $decodedResponseBody = json_decode($responseBody, true);
        return $decodedResponseBody;
    }
}
