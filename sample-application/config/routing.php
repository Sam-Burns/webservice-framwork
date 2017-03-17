<?php

return [

    'store-person' =>
        [
            'path'                  => '/store-person/{name}/{jobTitle}',
            'method'                => 'GET',
            'controller-service-id' => 'kata-api.controller.person',
            'action-method'         => 'storePersonAction'
        ],

    'find-all-people' =>
        [
            'path'                  => '/find-all-people',
            'method'                => 'GET',
            'controller-service-id' => 'kata-api.controller.person',
            'action-method'         => 'findAllPeopleAction'
        ]

];
