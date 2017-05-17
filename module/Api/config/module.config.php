<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */

namespace Api;

use Zend\Db\Adapter as DbAdapter;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'products' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/products[/:id][/]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProductsController::class,
                    ],
                ],
            ],
            'users' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/api/users[/:id][/]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                    ],
                ],
            ],
            'login_check' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/api/login_check',
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action' => 'login_check',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ProductsController::class => Controller\ProductsControllerFactory::class,
            Controller\UsersController::class => Controller\UsersControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\ProductsForm::class => Form\ProductsFormFactory::class,
            Form\UsersForm::class => Form\UsersFormFactory::class,
            Form\LoginForm::class => Form\LoginFormFactory::class,
        ],
    ],
];
