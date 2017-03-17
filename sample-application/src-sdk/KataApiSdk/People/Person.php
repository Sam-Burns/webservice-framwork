<?php
namespace KataApiSdk\People;

class Person
{
    /** @var string */
    private $name;

    /** @var string */
    private $jobTitle;

    public function __construct(string $name, string $jobTitle)
    {
        $this->name = $name;
        $this->jobTitle = $jobTitle;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getJobTitle() : string
    {
        return $this->jobTitle;
    }
}
