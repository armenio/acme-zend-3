<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Api\Form;

use Armenio\Cake\ORM\TableRegistry;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter as DbAdapter;
use Zend\Form\FormInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ProductsFormFactory
 * @package Api\Form
 */
class ProductsFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $formName
     * @param array|null $options
     * @return FormInterface
     */
    public function __invoke(ContainerInterface $container, $formName, array $options = null)
    {
        $tableRegistry = $container->get(TableRegistry::class);
        $db = $container->get(DbAdapter::class);

        $form = new ProductsForm($tableRegistry, $db);

        return $form;
    }
}
