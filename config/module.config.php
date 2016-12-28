<?php
return array(
    'module' => array(
        'Install' => array(
            'name' => 'Install',
            'version' => '1.0.3',
            'install' => array(
                'require' => array(),
            )
        ),
    ),
    
    'controllers' => array(
        'factories' => array(
            'Install\Controller\Index' => 'Install\Controller\Factory\IndexControllerFactory',
            'Install\Controller\Config' => 'Install\Controller\Factory\ConfigControllerFactory',
            'Install\Controller\Admin' => 'Install\Controller\Factory\AdminControllerfactory',
            'Install\Controller\Database' => 'Install\Controller\Factory\DatabaseControllerFactory',
            'Install\Controller\Complete' => 'Install\Controller\Factory\CompleteControllerFactory'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Install\Mapper\MysqlMapperInterface' => 'Install\Mapper\Factory\MysqlMapperFactory',
            'Install\Service\ServiceInterface' => 'Install\Service\Factory\ServiceFactory',
            'Install\Form\AdminForm' => 'Install\Form\Factory\AdminFormFactory'
        )
    ),
    'router' => array(
        'routes' => array(
            'install-index' => array(
                'pageTitle' => 'Install',
                'pageSubTitle' => 'Start',
                'activeMenuItem' => '',
                'activeSubMenuItem' => '',
                'layout' => 'install',
                'type' => 'literal',
                'options' => array(
                    'route' => '/install',
                    'defaults' => array(
                        'controller' => 'Install\Controller\Index',
                        'action' => 'index'
                    )
                )
            ),
            'install-database' => array(
                'pageTitle' => 'Install',
                'pageSubTitle' => 'Database',
                'activeMenuItem' => '',
                'activeSubMenuItem' => '',
                'layout' => 'install',
                'type' => 'literal',
                'options' => array(
                    'route' => '/install/database',
                    'defaults' => array(
                        'controller' => 'Install\Controller\Database',
                        'action' => 'index'
                    )
                )
            ),
            'install-config' => array(
                'pageTitle' => 'Install',
                'pageSubTitle' => 'Config',
                'activeMenuItem' => '',
                'activeSubMenuItem' => '',
                'layout' => 'install',
                'type' => 'literal',
                'options' => array(
                    'route' => '/install/config',
                    'defaults' => array(
                        'controller' => 'Install\Controller\Config',
                        'action' => 'index'
                    )
                )
            ),
            'install-admin' => array(
                'pageTitle' => 'Install',
                'pageSubTitle' => 'Admin',
                'activeMenuItem' => '',
                'activeSubMenuItem' => '',
                'layout' => 'install',
                'type' => 'literal',
                'options' => array(
                    'route' => '/install/admin',
                    'defaults' => array(
                        'controller' => 'Install\Controller\Admin',
                        'action' => 'index'
                    )
                )
            ),
            'install-complete' => array(
               'pageTitle' => 'Install',
                'pageSubTitle' => 'Completed',
                'activeMenuItem' => '',
                'activeSubMenuItem' => '',
                'layout' => 'install',
                'type' => 'literal',
                'options' => array(
                    'route' => '/install/complete',
                    'defaults' => array(
                        'controller' => 'Install\Controller\Complete',
                        'action' => 'index'
                    )
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    'acl' => array(
        'guest' => array(),
        'user' => array(),
        'administrator' => array()
    ),
    'menu' => array(
        'default' => array(
            array(
                'name' => 'Admin',
                'route' => 'admin-index',
                'icon' => 'fa fa-gear',
                'order' => 99,
                'active' => true,
                'items' => array()
            )
        )
    )
);