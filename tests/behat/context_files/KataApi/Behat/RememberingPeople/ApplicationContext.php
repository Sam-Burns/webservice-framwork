<?php
namespace KataApi\Behat\RememberingPeople;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use KataApiSdk\People\PeopleService;
use PHPUnit\Framework\Assert;
use UltraLite\CompositeContainer\CompositeContainer;
use UltraLite\Container\Container;
use KataApiSdk\People\Person;

class ApplicationContext implements Context
{
    private $container;

    /** @var Person[] */
    private $allPeople;

    public function __construct()
    {
        $this->container = new CompositeContainer();

        // Add test override services
        $this->addServices($this->container, __DIR__ . '/../../../../../../config/kata-sdk/services-test.php');

        // Add production services
        $this->addServices($this->container, __DIR__ . '/../../../../../../config/kata-sdk/services.php');
    }

    private function addServices(CompositeContainer $compositeContainer, string $pathToConfig)
    {
        $container = new Container();
        $container->configureFromFile($pathToConfig);
        $compositeContainer->addContainer($container);
        $container->setDelegateContainer($compositeContainer);
    }

    /**
     * @Given :name is a :jobTitle
     */
    public function isA(string $name, string $jobTitle)
    {
        $peopleService = $this->container->get('kata-api-sdk.people-service');
        /** @var $peopleService PeopleService */
        $peopleService->storePerson($name, $jobTitle);
    }

    /**
     * @When I look up all the people in the team
     */
    public function iLookUpAllThePeopleInTheTeam()
    {
        $peopleService = $this->container->get('kata-api-sdk.people-service');
        /** @var $peopleService PeopleService */
        $this->allPeople = $peopleService->lookUpAllPeople();
    }

    /**
     * @Then I should get :noOfPeople people
     */
    public function iShouldGetPeople(int $noOfPeople)
    {
        Assert::assertCount($noOfPeople, $this->allPeople);
    }

    /**
     * @Then one of them should be called :name
     */
    public function oneOfThemShouldBeCalled(string $name)
    {
        $foundExpectedName = false;

        foreach ($this->allPeople as $person) {
            $foundExpectedName = $foundExpectedName || $person->getName() === $name;
        }

        Assert::assertTrue($foundExpectedName);
    }
}
