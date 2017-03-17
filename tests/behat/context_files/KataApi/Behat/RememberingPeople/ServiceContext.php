<?php
namespace KataApi\Behat\RememberingPeople;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use KataApi\People\Name;
use KataApi\People\JobTitle;
use KataApi\People\Person;
use PHPUnit\Framework\Assert;
use Psr\Container\ContainerInterface;
use UltraLite\CompositeContainer\CompositeContainer;
use UltraLite\Container\Container;
use KataApi\Infrastructure\PeopleStorage\InMemoryPeopleStorage;

class ServiceContext implements Context
{
    /** @var ContainerInterface */
    private $container;

    /** @var Person[] */
    private $peopleRetrieved;

    /** @var Person */
    private $personRetrieved;

    public function __construct()
    {
        $this->container = new CompositeContainer();

        // Add test override services
        $this->addServices($this->container, __DIR__ . '/../../../../../../config/kata-api/services-test.php');

        // Add production services
        $this->addServices($this->container, __DIR__ . '/../../../../../../config/kata-api/services.php');
    }

    private function addServices(CompositeContainer $compositeContainer, string $pathToConfig)
    {
        $container = new Container();
        $container->configureFromFile($pathToConfig);
        $compositeContainer->addContainer($container);
        $container->setDelegateContainer($compositeContainer);
    }

    /**
     * @transform :name
     */
    public function transformName(string $name) : Name
    {
        return Name::fromString($name);
    }

    /**
     * @transform :jobTitle
     */
    public function transformJobTitle(string $jobTitle) : JobTitle
    {
        return JobTitle::fromString($jobTitle);
    }

    /**
     * @Given :name is a :jobTitle
     */
    public function isA(Name $name, JobTitle $jobTitle)
    {
        $this->getInMemoryPeopleStorage()->storePerson(Person::fromNameAndTitle($name, $jobTitle));
    }

    /**
     * @When I look up all the people in the team
     */
    public function iLookUpAllThePeopleInTheTeam()
    {
        $this->peopleRetrieved = $this->getInMemoryPeopleStorage()->findAllPeople();
    }

    /**
     * @Then I should get :noOfPeople people
     */
    public function iShouldGetPeople(int $noOfPeople)
    {
        Assert::assertCount($noOfPeople, $this->peopleRetrieved);
    }

    /**
     * @Then one of them should be called :name
     */
    public function oneOfThemShouldBeCalled(Name $name)
    {
        $foundExpectedName = false;

        foreach ($this->peopleRetrieved as $person) {
            $foundExpectedName = $foundExpectedName || $person->isCalled($name);
        }

        Assert::assertTrue($foundExpectedName);
    }

    /**
     * @When I look up what Hash's job is
     */
    public function iLookUpWhatHashSJobIs()
    {
        $this->personRetrieved = $this->getInMemoryPeopleStorage()->findByName(Name::fromString('Hash'));;
    }

    /**
     * @Then I should see he is a :jobTitle
     */
    public function iShouldSeeHeIsA(JobTitle $jobTitle)
    {
        Assert::assertTrue($this->personRetrieved->hasTitle($jobTitle));
    }

    private function getInMemoryPeopleStorage() : InMemoryPeopleStorage
    {
        return $this->container->get('kata-api.infrastructure.people-storage');
    }

    /**
     * @When I look up the number of team members with a prime number of vowels in their name
     */
    public function iLookUpTheNumberOfTeamMembersWithAPrimeNumberOfVowelsInTheirName()
    {
        throw new PendingException();
    }

    /**
     * @Then I should find that there are :arg1
     */
    public function iShouldFindThatThereAre($arg1)
    {
        throw new PendingException();
    }
}
