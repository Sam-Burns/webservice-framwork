<?php

use Psr\Container\ContainerInterface;

return [

    'kata-api.infrastructure.people-storage' => function (ContainerInterface $container) {
        return new \KataApi\Infrastructure\PeopleStorage\InMemoryPeopleStorage();
    },

];
