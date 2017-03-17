<?php
namespace KataApi\Application;

use Psr\Container\ContainerInterface;
use UltraLite\Container\Container;
use UltraLite\CompositeContainer\CompositeContainer;

class ContainerBuilder
{
    public function getProdContainer() : ContainerInterface
    {
        $container = new Container();
        $container->configureFromFile(__DIR__ . '/../../../config/kata-api/services.php');
        return $container;
    }

    public function getTestContainer() : ContainerInterface
    {
        $container = new CompositeContainer();

        // Add test override services
        $this->addServices($container, __DIR__ . '/../../../config/kata-api/services-test.php');

        // Add production services
        $this->addServices($container, __DIR__ . '/../../../config/kata-api/services.php');

        return $container;
    }

    private function addServices(CompositeContainer $compositeContainer, string $pathToConfig)
    {
        $container = new Container();
        $container->configureFromFile($pathToConfig);
        $compositeContainer->addContainer($container);
        $container->setDelegateContainer($compositeContainer);
    }
}
