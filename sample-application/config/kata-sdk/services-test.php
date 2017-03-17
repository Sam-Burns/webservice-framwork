<?php

use Psr\Container\ContainerInterface;

return [

    'kata-api-sdk.application' => function (ContainerInterface $container) {
        return new KataApi\Application\Application(true);
    },

    'kata-api-sdk.api-client' => function (ContainerInterface $container) {
        $application = $container->get('kata-api-sdk.application');
        return new \KataApiSdk\ApiClient\ApplicationTestClient($application, $container);
    },

];
