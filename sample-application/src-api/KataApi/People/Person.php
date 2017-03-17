<?php

namespace KataApi\People;

class Person
{
    /** @var Name */
    private $name;

    /** @var JobTitle */
    private $jobTitle;

    private function __construct(Name $name, JobTitle $jobTitle)
    {
        $this->name = $name;
        $this->jobTitle = $jobTitle;
    }

    public static function fromNameAndTitle(Name $name, JobTitle $jobTitle) : Person
    {
        $person = new Person($name, $jobTitle);
        return $person;
    }

    public function isCalled(Name $anotherName) : bool
    {
        return $this->name->equals($anotherName);
    }

    public function hasTitle(JobTitle $aJobTitle) : bool
    {
        return $this->jobTitle->equals($aJobTitle);
    }

    public function toArray() : array
    {
        return [
            'name'      => (string) $this->name,
            'job-title' => (string) $this->jobTitle,
        ];
    }
}
