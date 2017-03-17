<?php
namespace KataApi\Application;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as SlimApp;
use Zend\Diactoros\Response;

class Application
{
    /** @var ContainerInterface */
    private $container;

    public function __construct($testMode = false)
    {
        $containerBuilder = new ContainerBuilder();
        $this->container = $testMode ? $containerBuilder->getTestContainer() : $containerBuilder->getProdContainer();
    }

    public function run()
    {
        $slimApp = $this->prepareApplication();
        $slimApp->run();
    }

    public function runAgainstRequest(ServerRequestInterface $request) : ResponseInterface
    {
        $slimApp = $this->prepareApplication();
        return $slimApp->process($request, new Response());
    }

    private function prepareApplication() : SlimApp
    {
        $routingConfig = $this->getRoutingConfig();

        $slimApp = new SlimApp();

        foreach ($routingConfig as $route) {
            $this->addRouteToSlimFramework($slimApp, $route, $this->container);
        }

        return $slimApp;
    }

    private function getRoutingConfig(): array
    {
        return require __DIR__ . '/../../../config/routing.php';
    }

    private function addRouteToSlimFramework(SlimApp $slimApp, array $route, ContainerInterface $container)
    {
        $controllerClosure =
            function ($request, $response, $args) use ($container, $route) {
                $controller = $container->get($route['controller-service-id']);
                $actionMethod = $route['action-method'];
                return $controller->$actionMethod($request, $response, $args);
            };

        $httpVerb = strtolower($route['method']);

        $slimApp->$httpVerb($route['path'], $controllerClosure);
    }
}
