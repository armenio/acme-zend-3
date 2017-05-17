<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Application\Form;

use Armenio\Cake\ORM\TableRegistry;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter as DbAdapter;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LoginFormFactory
 * @package Application\Form
 */
class LoginFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $formName
     * @param array|null $options
     * @return LoginForm
     */
    public function __invoke(ContainerInterface $container, $formName, array $options = null)
    {
        $tableRegistry = $container->get(TableRegistry::class);
        $db = $container->get(DbAdapter::class);

        $form = new LoginForm($tableRegistry, $db);

        return $form;
    }
}
