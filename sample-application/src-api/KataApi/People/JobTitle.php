<?php

namespace KataApi\People;

class JobTitle
{
    /** @var string */
    private $jobTitle;

    private function __construct(string $jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    public static function fromString(string $jobTitle) : JobTitle
    {
        $jobTitle = new JobTitle($jobTitle);
        return $jobTitle;
    }

    public function __toString() : string
    {
        return $this->jobTitle;
    }

    public function equals(JobTitle $another) : bool
    {
        return $this->jobTitle === $another->jobTitle;
    }
}
