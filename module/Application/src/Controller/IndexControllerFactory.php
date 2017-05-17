<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Application\Controller;

use Armenio\Cake\ORM\TableRegistry;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\Container as SessionContainer;
use Zend\View\Renderer\RendererInterface;

/**
 * Class IndexControllerFactory
 * @package Application\Controller
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $controllerName
     * @param array|null $options
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container, $controllerName, array $options = null)
    {
        $tableRegistry = $container->get(TableRegistry::class);
        $session = $container->get(SessionContainer::class);
        $authentication = $container->get(AuthenticationService::class);
        $formManager = $container->get('FormElementManager');
        $viewRenderer = $container->get(RendererInterface::class);

        $controller = new IndexController($tableRegistry, $session, $authentication, $formManager, $viewRenderer);

        return $controller;
    }
}
