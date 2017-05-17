<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Application;

use Zend\Cache\Storage\StorageInterface as CacheStorageInterface;
use Zend\Db\Adapter as DbAdapter;
use Zend\Router\Http\Segment;
use Zend\Session\Container as SessionContainer;
use Zend\Session\Storage\SessionArrayStorage;

return [
    'router' => [
        'routes' => [

            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/[:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        //'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'products' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/produtos[/:id][/]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProdutosController::class,
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => false,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'db' => [
        'adapters' => [
            DbAdapter::class => [
                'driver' => 'Pdo_Mysql',
                'host' => 'localhost',
                'username' => 'username',
                'password' => 'password',
                'dbname' => 'acme',
                'charset' => 'utf8',
            ],
        ],
    ],
    'Cake' => [
        'Configure' => [
            'App' => [
                'namespace' => 'Application',
            ],
        ],
        'Datasources' => [
            'default' => [
                'cacheMetadata' => false,
                'log' => false,
            ],
        ],
    ],
    'authentication' => [
        'table_name' => 'users',
        'identity_column' => 'username',
        'credential_column' => 'password',
        'remember_me' => 60 * 60,
        'crypt_cost' => 10,
        'check_is_active' => false,
        'join_tables' => [],
    ],
    'caches' => [
        CacheStorageInterface::class => [
            'adapter' => [
                'name' => 'filesystem',
            ],
            'options' => [
                'cache_dir' => 'data/cache/',
                'ttl' => 365 * 24 * 60 * 60,
            ],
            'plugins' => [
                'serializer',
            ],
        ],
    ],
    'session_containers' => [
        SessionContainer::class,
    ],
    'session_config' => [
        'name' => md5(ROOT_PATH),
    ],
    'session_storage' => [
        'type' => SessionArrayStorage::class,
    ],
    'translator' => [
        'locale' => 'pt_BR',
        'translation_file_patterns' => [
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../resources/languages',
                'pattern' => '%s/Zend_Misc.php',
            ],
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../resources/languages',
                'pattern' => '%s/Zend_Validate.php',
            ],
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../resources/languages',
                'pattern' => '%s/Zend_Authentication.php',
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\ProdutosController::class => Controller\ProdutosControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\LoginForm::class => Form\LoginFormFactory::class,
            Form\ContactsForm::class => Form\ContactsFormFactory::class,
            Form\GroupsForm::class => Form\GroupsFormFactory::class,
            Form\UsersForm::class => Form\UsersFormFactory::class,
        ],
    ],
];
