<?php

namespace KataApiSpec\KataApi\People;

use KataApi\People\JobTitle;
use PhpSpec\ObjectBehavior;

/**
 * @mixin JobTitle
 */
class JobTitleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['Project Manager']);
    }

    function it_can_be_converted_to_a_string()
    {
        $this->__toString()->shouldBe('Project Manager');
    }

    function it_can_tell_if_it_is_equal_to_another()
    {
        $this->equals(JobTitle::fromString('Project Manager'))->shouldBe(true);
        $this->equals(JobTitle::fromString('Dev'))->shouldBe(false);
    }
}
