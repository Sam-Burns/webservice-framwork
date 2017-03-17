<?php
namespace KataApi\People;

interface PeopleStorage
{
    public function storePerson(Person $personToStore);

    /**
     * @return Person|null
     */
    public function findByName(Name $name);

    /**
     * @return Person[]
     */
    public function findAllPeople() : array;
}
