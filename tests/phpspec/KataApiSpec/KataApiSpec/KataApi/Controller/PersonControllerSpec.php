<?php

namespace KataApiSpec\KataApi\Controller;

use KataApi\Controller\PersonController;
use KataApi\People\Person;
use PhpSpec\ObjectBehavior;
use KataApi\People\PeopleStorage;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @mixin PersonController
 */
class PersonControllerSpec extends ObjectBehavior
{
    function let(PeopleStorage $peopleStorage)
    {
        $this->beConstructedWith($peopleStorage);
    }

    function test_it_can_store_people(
        RequestInterface  $request,
        ResponseInterface $response,
        PeopleStorage     $peopleStorage
    ) {
        $argsInRoute = ['name' => 'Sam', 'jobTitle' => 'Dev'];

        $this->storePersonAction($request, $response, $argsInRoute);

        $peopleStorage->storePerson(Argument::type(Person::class))->shouldHaveBeenCalled();
    }
}
