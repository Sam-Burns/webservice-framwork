<?php

namespace KataApiSpec\KataApi\Infrastructure\PeopleStorage;

use KataApi\Infrastructure\PeopleStorage\InMemoryPeopleStorage;
use KataApi\People\Name;
use KataApi\People\Person;
use PhpSpec\ObjectBehavior;

/**
 * @mixin InMemoryPeopleStorage
 */
class InMemoryPeopleStorageSpec extends ObjectBehavior
{
    function it_can_find_people_by_name(Name $nameToSearchFor, Person $person1, Person $person2)
    {
        $person1->isCalled($nameToSearchFor)->willReturn(false);
        $person2->isCalled($nameToSearchFor)->willReturn(true);

        $this->storePerson($person1);
        $this->storePerson($person2);

        $this->findByName($nameToSearchFor)->shouldBe($person2);
    }

    function it_can_find_all_people(Person $person1, Person $person2)
    {
        $this->storePerson($person1);
        $this->storePerson($person2);

        $this->findAllPeople()->shouldBe([$person1, $person2]);
    }
}
