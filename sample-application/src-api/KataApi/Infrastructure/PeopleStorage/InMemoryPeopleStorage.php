<?php

namespace KataApi\Infrastructure\PeopleStorage;

use KataApi\People\Name;
use KataApi\People\PeopleStorage;
use KataApi\People\Person;

class InMemoryPeopleStorage implements PeopleStorage
{
    /** @var Person[] */
    private $peopleStored = [];

    public function storePerson(Person $personToStore)
    {
        $this->peopleStored[] = $personToStore;
    }

    /**
     * @return Person|null
     */
    public function findByName(Name $name)
    {
        foreach ($this->peopleStored as $person) {
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
        return $this->peopleStored;
    }
}
