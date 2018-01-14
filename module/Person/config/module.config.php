<?php

declare(strict_types=1);

use Person\Form\PersonForm;
use Person\Form\OrganizationForm;
use Zend\Router\Http\Literal;
use Person\Controller;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'persons' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/persons',
                    'defaults' => [
                        'controller' => Controller\PersonController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/new',
                            'defaults' => [
                                'action'     => 'add',
                            ],
                        ],
                    ],
                ],
            ],
            'organizations' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/organizations',
                    'defaults' => [
                        'controller' => Controller\OrganizationController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/new',
                            'defaults' => [
                                'action'     => 'add',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\PersonController::class => Controller\PersonControllerFactory::class,
            Controller\OrganizationController::class => Controller\OrganizationControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            PersonForm::class => InvokableFactory::class,
            OrganizationForm::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'person/person/index' => __DIR__ . '/../view/person/index/index.phtml',
            'person/person/add' => __DIR__ . '/../view/person/index/add.phtml',
            'person/organization/index' => __DIR__ . '/../view/organization/index/index.phtml',
            'person/organization/add' => __DIR__ . '/../view/organization/index/add.phtml',
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'person_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../src/Entity/',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `application_driver` for any entity under namespace `Application\Entity`
                    'Person\Entity' => 'person_driver',
                ],
            ],
        ],
    ],
];
