<?php

use Psr\Container\ContainerInterface;

return [

    'kata-api.controller.person' => function (ContainerInterface $container) {
        $peopleStorage = $container->get('kata-api.infrastructure.people-storage');
        return new \KataApi\Controller\PersonController($peopleStorage);
    },

    'kata-api.infrastructure.people-storage' => function (ContainerInterface $container) {
        return new \KataApi\Infrastructure\PeopleStorage\SerialiserPeopleStorage();
    },

];
