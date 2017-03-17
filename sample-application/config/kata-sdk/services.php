<?php

use Psr\Container\ContainerInterface;

return [

//    'kata-api-sdk.api-client' => function (ContainerInterface $container) {
//        $guzzleClient = new GuzzleHttp\Client();
//        return new \KataApiSdk\ApiClient\HttpClient($guzzleClient, 'localhost', '8012');
//    },

    'kata-api-sdk.people-service' => function (ContainerInterface $container) {
        $apiClient = $container->get('kata-api-sdk.api-client');
        return new \KataApiSdk\People\PeopleService($apiClient);
    },

];
