<?php
namespace KataApiSdkSpec\KataApiSdk\People;

use PhpSpec\ObjectBehavior;
use KataApiSdk\People\Person;

/**
 * @mixin Person
 */
class PersonSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Jeremy', 'Scrum-Master');
    }

    function it_can_return_the_name_and_job_title()
    {
        $this->getName()->shouldBe('Jeremy');
        $this->getJobTitle()->shouldBe('Scrum-Master');
    }
}
