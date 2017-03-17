<?php
namespace KataApiTest;

use KataApi\Application\ContainerBuilder as ApiContainerBuilder;
use KataApiSdk\ContainerBuilder as SdkContainerBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use UltraLite\Container\Container;

class DiConfigTest extends TestCase
{
    /**
     * @dataProvider provideAllServicesDefined
     */
    public function testServiceCanBeRetrieved(ContainerInterface $container, string $serviceIdToTest)
    {
        $result = $container->get($serviceIdToTest);
        $this->assertInternalType('object', $result);
    }

    /**
     * Data provider.  Returns array of all service IDs mentioned in config files, like:
     * array(
     *     array($container, 'service-id-1')
     * )
     */
    public function provideAllServicesDefined() : array
    {
        $tests = [];

        $containers = $this->getProductionContainers();

        foreach ($containers as $container) {
            foreach ($container->listServiceIds() as $serviceId) {
                $tests[] = [$container, $serviceId];
            }
        }

        return $tests;
    }

    public function testContainerBuildersReturnContainers()
    {
        foreach ($this->getAllContainers() as $container) {
            $this->assertInstanceOf(ContainerInterface::class, $container);
        }
    }

    /**
     * @return Container[]
     */
    private function getProductionContainers() : array
    {
        $apiContainerBuilder = new ApiContainerBuilder();
        $sdkContainerBuilder = new SdkContainerBuilder();

        return [
            'api-prod' => $apiContainerBuilder->getProdContainer(),
            'sdk-prod' => $sdkContainerBuilder->getProdContainer(),
        ];
    }

    /**
     * @return Container[]
     */
    private function getAllContainers() : array
    {
        $apiContainerBuilder = new ApiContainerBuilder();
        $sdkContainerBuilder = new SdkContainerBuilder();

        return [
            'api-prod' => $apiContainerBuilder->getProdContainer(),
            'sdk-prod' => $sdkContainerBuilder->getProdContainer(),
            'api-test' => $apiContainerBuilder->getTestContainer(),
            'sdk-test' => $sdkContainerBuilder->getTestContainer(),
        ];
    }
}
