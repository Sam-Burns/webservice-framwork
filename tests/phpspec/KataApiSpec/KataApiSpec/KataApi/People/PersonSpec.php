<?php

namespace KataApiSpec\KataApi\People;

use KataApi\People\JobTitle;
use KataApi\People\Name;
use KataApi\People\Person;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Person
 */
class PersonSpec extends ObjectBehavior
{
    function let(Name $name, JobTitle $jobTitle)
    {
        $this->beConstructedThrough('fromNameAndTitle', [$name, $jobTitle]);
    }

    function it_can_tell_if_the_person_is_called_something(Name $name)
    {
        $name->equals(Argument::any())->willReturn(true);
        $this->isCalled(Name::fromString('Jeremy'))->shouldBe(true);

        $name->equals(Argument::any())->willReturn(false);
        $this->isCalled(Name::fromString('Hash'))->shouldBe(false);
    }

    function it_can_tell_if_the_person_has_a_specific_title(JobTitle $jobTitle)
    {
        $jobTitle->equals(Argument::any())->willReturn(true);
        $this->hasTitle(JobTitle::fromString('Dev'))->shouldBe(true);

        $jobTitle->equals(Argument::any())->willReturn(false);
        $this->hasTitle(JobTitle::fromString('Scrum-Master'))->shouldBe(false);
    }
}
