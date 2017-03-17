<?php

namespace KataApi\Infrastructure\PeopleStorage;

use KataApi\People\JobTitle;
use KataApi\People\Name;
use KataApi\People\PeopleStorage;
use KataApi\People\Person;

class SerialiserPeopleStorage implements PeopleStorage
{
    /** @var string */
    private $storageFile = __DIR__ . '/../../../../db/people';

    public function storePerson(Person $personToStore)
    {
        $peopleStored = $this->findAllPeople();
        $peopleStored[] = $personToStore;
        file_put_contents($this->storageFile, $this->toJson($peopleStored));
    }

    /**
     * @return Person|null
     */
    public function findByName(Name $name)
    {
        $peopleStored = $this->findAllPeople();
        foreach ($peopleStored as $person) {
            if ($person->isCalled($name)) {
                return $person;
            }
        }
        return null;
    }

    /**
     * @return Person[]
     */
    public function findAllPeople() : array
    {
        if (!file_exists($this->storageFile)) {
            return [];
        }
        $contents = file_get_contents($this->storageFile);
        return $this->fromJson($contents);
    }

    /**
     * @param Person[] $people
     */
    private function toJson(array $people) : string
    {
        $arrayRepresentation = [];
        foreach ($people as $person) {
            $arrayRepresentation[] = $person->toArray();
        }
        return json_encode($arrayRepresentation);
    }

    /**
     * @return Person[]
     */
    private function fromJson(string $json) : array
    {
        $array = json_decode($json, true);

        $people = [];

        foreach ($array as $personRepresentation) {
            $name = $personRepresentation['name'];
            $jobTitle = $personRepresentation['job-title'];
            $people[] = Person::fromNameAndTitle(Name::fromString($name), JobTitle::fromString($jobTitle));
        }

        return $people;
    }
}
