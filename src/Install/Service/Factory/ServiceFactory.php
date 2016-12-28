<?php
namespace Install\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Install\Service\Service;

class ServiceFactory
{

    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Install\Service\Service
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $mapper = $serviceLocator->get('Install\Mapper\MysqlMapperInterface');
        
        $resourceService = $serviceLocator->get('AclResource\Service\ServiceInterface');
        
        $roleService = $serviceLocator->get('AclRole\Service\ServiceInterface');
        
        $aclService = $serviceLocator->get('Acl\Service\ServiceInterface');
        
        $menuService = $serviceLocator->get('Menu\Service\ServiceInterface');
        
        $moduleService = $serviceLocator->get('Module\Service\ServiceInterface');
        
        $pageService = $serviceLocator->get('Page\Service\ServiceInterface');
        
        $menuItemService = $serviceLocator->get('MenuItem\Service\ServiceInterface');
        
        $controllerService = $serviceLocator->get('Controller\Service\ServiceInterface');
        
        return new Service($mapper, $resourceService, $roleService, $aclService, $menuService, $moduleService, $pageService, $menuItemService, $controllerService);
    }
}
