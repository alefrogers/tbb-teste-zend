<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'type-list' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Type',
                        'action' => 'index',
                    ),
                ),
            ),
            'type-create' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/type/create',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Type',
                        'action' => 'create',
                    ),
                ),
            ),
            'type-edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/type/edit/[:id]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Type',
                        'action' => 'edit',
                    ),
                ),
            ),
            'type-storage' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/type/storage',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Type',
                        'action' => 'storage',
                    ),
                ),
            ),
            'type-remove' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/type/remove/[:id]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Type',
                        'action' => 'remove',
                    ),
                ),
            ),
            'simulation-list' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/simulation',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Simulation',
                        'action' => 'index',
                    ),
                ),
            ),
            'simulation-create' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/simulation/create',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Simulation',
                        'action' => 'create',
                    ),
                ),
            ),
            'simulation-insert' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/simulation/insert',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Simulation',
                        'action' => 'insert',
                    ),
                ),
            ),
            'simulation-edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/simulation/edit/[:id]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\simulation',
                        'action' => 'edit',
                    ),
                ),
            ),
            'simulation-update' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/simulation/update/[:id]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\simulation',
                        'action' => 'update',
                    ),
                ),
            ),
            'simulation-remove' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/simulation/remove/[:id]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\simulation',
                        'action' => 'remove',
                    ),
                ),
            )
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Type' => 'Application\Controller\Investments\TypesInvestmentsController',
            'Application\Controller\Simulation' => 'Application\Controller\Investments\SimulationsInvestmentsController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'investments/types/list' => __DIR__ . '/../view/application/investments/types/list.phtml',
            'investments/types/create' => __DIR__ . '/../view/application/investments/types/create.phtml',
            'investments/types/edit' => __DIR__ . '/../view/application/investments/types/edit.phtml',
            'investments/simulations/list' => __DIR__ . '/../view/application/investments/simulations/list.phtml',
            'investments/simulations/create' => __DIR__ . '/../view/application/investments/simulations/create.phtml',
            'investments/simulations/edit' => __DIR__ . '/../view/application/investments/simulations/edit.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . "/../src/Application/Model"
                ),
            ),
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Application\Model' => 'my_annotation_driver'
                )
            )
        )
    )
);
