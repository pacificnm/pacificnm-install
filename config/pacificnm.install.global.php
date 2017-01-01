<?php
return array(
    'module' => array(
        'Install' => array(
            'name' => 'Install',
            'version' => '1.0.5',
            'install' => array(
                'require' => array(),
            )
        ),
    ),
    
    'controllers' => array(
        'factories' => array(
            'Pacificnm\Install\Controller\Index' => 'Pacificnm\Install\Controller\Factory\IndexControllerFactory',
            'Pacificnm\Install\Controller\Config' => 'Pacificnm\Install\Controller\Factory\ConfigControllerFactory',
            'Pacificnm\Install\Controller\Admin' => 'Pacificnm\Install\Controller\Factory\AdminControllerfactory',
            'Pacificnm\Install\Controller\Database' => 'Pacificnm\Install\Controller\Factory\DatabaseControllerFactory',
            'Pacificnm\Install\Controller\Complete' => 'Pacificnm\Install\Controller\Factory\CompleteControllerFactory'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Pacificnm\Install\Mapper\MysqlMapperInterface' => 'Pacificnm\Install\Mapper\Factory\MysqlMapperFactory',
            'Pacificnm\Install\Service\ServiceInterface' => 'Pacificnm\Install\Service\Factory\ServiceFactory',
            'Pacificnm\Install\Form\AdminForm' => 'Pacificnm\Install\Form\Factory\AdminFormFactory'
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
                        'controller' => 'Pacificnm\Install\Controller\Index',
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
                        'controller' => 'Pacificnm\Install\Controller\Database',
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
                        'controller' => 'Pacificnm\Install\Controller\Config',
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
                        'controller' => 'Pacificnm\Install\Controller\Admin',
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
                        'controller' => 'Pacificnm\Install\Controller\Complete',
                        'action' => 'index'
                    )
                )
            ),
        ),
    ),
    'view_manager' => array(
        'controller_map' => array(
            'Pacificnm\Install' => true
        ),
        'template_map' => array(
            'pacificnm/install/admin/index' => __DIR__ . '/../view/install/admin/index.phtml',
            'pacificnm/install/complete/index' => __DIR__ . '/../view/install/complete/index.phtml',
            'pacificnm/install/config/index' => __DIR__ . '/../view/install/config/index.phtml',
            'pacificnm/install/database/index' => __DIR__ . '/../view/install/database/index.phtml',
            'pacificnm/install/index/index' => __DIR__ . '/../view/install/index/index.phtml',
        ),
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