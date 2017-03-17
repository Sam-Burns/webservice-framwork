<?php

namespace KataApiSdkSpec\KataApiSdk\People;

use KataApiSdk\ApiClient;
use KataApiSdk\People\PeopleService;
use KataApiSdk\People\Person;
use PhpSpec\ObjectBehavior;

/**
 * @mixin PeopleService
 */
class PeopleServiceSpec extends ObjectBehavior
{
    function let(ApiClient $apiClient)
    {
        $this->beConstructedWith($apiClient);
    }

    function it_can_store_a_person(ApiClient $apiClient)
    {
        $apiClient->request('/store-person/Abi/QA', 'GET')->shouldBeCalled()->willReturn([]);
        $this->storePerson('Abi', 'QA');
    }

    function it_can_find_all_people(ApiClient $apiClient)
    {
        $apiClientResponseData = [
            'data' => [
                [
                    'name' => 'Tahir',
                    'job-title' => 'Dev'
                ]
            ]
        ];

        $apiClient->request("/find-all-people", 'GET')->willReturn($apiClientResponseData);

        $this->lookUpAllPeople()->shouldBeLike([new Person('Tahir', 'Dev')]);
    }
}
