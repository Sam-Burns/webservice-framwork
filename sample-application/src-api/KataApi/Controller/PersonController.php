<?php
namespace KataApi\Controller;

use KataApi\People\JobTitle;
use KataApi\People\Name;
use KataApi\People\PeopleStorage;
use KataApi\People\Person;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use Teapot\StatusCode\Http;

class PersonController
{
    /** @var PeopleStorage */
    private $peopleStorage;

    public function __construct(PeopleStorage $peopleStorage)
    {
        $this->peopleStorage = $peopleStorage;
    }

    public function storePersonAction(RequestInterface $request, ResponseInterface $response, array $args)
        : ResponseInterface
    {
        $personName = $args['name'];
        $jobTitle = $args['jobTitle'];

        $person = Person::fromNameAndTitle(Name::fromString($personName), JobTitle::fromString($jobTitle));
        $this->peopleStorage->storePerson($person);

        return new JsonResponse([], Http::OK);
    }

    public function findAllPeopleAction(RequestInterface $request, ResponseInterface $response, array $args)
        : ResponseInterface
    {
        $people = $this->peopleStorage->findAllPeople();

        $responseData = [
            'data' => [
            ],
        ];

        foreach ($people as $person) {
            $responseData['data'][] = $person->toArray();
        }

        return new JsonResponse($responseData, Http::OK);
    }
}
