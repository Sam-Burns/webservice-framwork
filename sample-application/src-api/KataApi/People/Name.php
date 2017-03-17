<?php

namespace KataApi\People;

class Name
{
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name) : Name
    {
        $name = new Name($name);
        return $name;
    }

    public function equals(Name $another) : bool
    {
        return $this->name === $another->name;
    }

    public function __toString() : string
    {
        return $this->name;
    }
}
