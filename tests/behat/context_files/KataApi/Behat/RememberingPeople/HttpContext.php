<?php
namespace KataApi\Behat\RememberingPeople;

use Behat\Behat\Context\Context;
use GuzzleHttp\Client;
use PHPUnit\Framework\Assert;
use Psr\Http\Message\ResponseInterface;

class HttpContext implements Context
{
    /** @var Client */
    private $guzzleClient;

    /** @var ResponseInterface */
    private $response;

    public function __construct()
    {
        $this->guzzleClient = new Client();
    }

    /**
     * @beforeScenario
     */
    public function setUp()
    {
        $storageFile = __DIR__ . '/../../../../../../db/people';
        if (file_exists($storageFile)) {
            unlink($storageFile);
        }
    }

    /**
     * @Given :name is a :jobTitle
     */
    public function isA(string $name, string $jobTitle)
    {
        $this->guzzleClient->get("http://localhost:8001/store-person/$name/$jobTitle");
    }

    /**
     * @When I look up all the people in the team
     */
    public function iLookUpAllThePeopleInTheTeam()
    {
        $this->response = $this->guzzleClient->get("http://localhost:8001/find-all-people");
    }

    /**
     * @Then I should get :noOfPeople people
     */
    public function iShouldGetPeople(int $noOfPeople)
    {
        $bodyArray = $this->getResponseBodyArray();
        Assert::assertCount($noOfPeople, $bodyArray['data']);
    }

    /**
     * @Then one of them should be called :name
     */
    public function oneOfThemShouldBeCalled(string $name)
    {
        $bodyArray = $this->getResponseBodyArray();

        $foundExpectedName = false;

        foreach ($bodyArray['data'] as $entries) {
            $foundExpectedName = $foundExpectedName || $entries['name'] === $name;
        }

        Assert::assertTrue($foundExpectedName);
    }

    private function getResponseBodyArray() : array
    {
        $bodyStream = $this->response->getBody();
        $bodyJson = $bodyStream->getContents();
        $bodyStream->rewind();
        $bodyArray = json_decode($bodyJson, true);
        return $bodyArray;
    }
}
