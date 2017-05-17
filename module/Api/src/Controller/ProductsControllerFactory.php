<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Api\Controller;

use Armenio\Cake\ORM\TableRegistry;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\Container as SessionContainer;
use Zend\View\Renderer\RendererInterface;

/**
 * Class ProductsControllerFactory
 * @package Application\Controller
 */
class ProductsControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $controllerName
     * @param array|null $options
     * @return ProductsController
     */
    public function __invoke(ContainerInterface $container, $controllerName, array $options = null)
    {
        $tableRegistry = $container->get(TableRegistry::class);
        $session = $container->get(SessionContainer::class);
        $authentication = $container->get(AuthenticationService::class);
        $formManager = $container->get('FormElementManager');
        $viewRenderer = $container->get(RendererInterface::class);

        $controller = new ProductsController($tableRegistry, $session, $authentication, $formManager, $viewRenderer);

        return $controller;
    }
}
