<?php

namespace KataApiSpec\KataApi\People;

use KataApi\People\Name;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Name
 */
class NameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('fromString', ['Abi']);
    }

    function it_can_check_for_equality()
    {
        $this->equals(Name::fromString('Usain Bolt'))->shouldBe(false);
        $this->equals(Name::fromString('Abi'))->shouldBe(true);
    }

    function it_can_be_converted_to_a_string()
    {
        $this->__toString()->shouldBe('Abi');
    }
}
