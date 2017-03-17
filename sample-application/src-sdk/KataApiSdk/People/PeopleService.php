<?php

namespace KataApiSdk\People;

use KataApiSdk\ApiClient;

class PeopleService
{
    /** @var ApiClient */
    private $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function storePerson(string $name, string $jobTitle)
    {
        $path = "/store-person/$name/$jobTitle";
        $this->apiClient->request($path, 'GET');
    }

    /**
     * @return Person[]
     */
    public function lookUpAllPeople() : array
    {
        $result = $this->apiClient->request("/find-all-people", 'GET');

        $people = [];
        foreach ($result['data'] as $personData) {
            $people[] = new Person($personData['name'], $personData['job-title']);
        }
        return $people;
    }
}
