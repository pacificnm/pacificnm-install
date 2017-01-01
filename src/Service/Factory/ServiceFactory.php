<?php
namespace Pacificnm\Install\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Pacificnm\Install\Service\Service;

class ServiceFactory
{

    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Pacificnm\Install\Service\Service
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $mapper = $serviceLocator->get('Pacificnm\Install\Mapper\MysqlMapperInterface');
        
        $resourceService = $serviceLocator->get('Pacificnm\AclResource\Service\ServiceInterface');
        
        $roleService = $serviceLocator->get('Pacificnm\AclRole\Service\ServiceInterface');
        
        $aclService = $serviceLocator->get('Pacificnm\Acl\Service\ServiceInterface');
        
        $menuService = $serviceLocator->get('Pacificnm\Menu\Service\ServiceInterface');
        
        $moduleService = $serviceLocator->get('Pacificnm\Module\Service\ServiceInterface');
        
        $pageService = $serviceLocator->get('Pacificnm\Page\Service\ServiceInterface');
        
        $menuItemService = $serviceLocator->get('Pacificnm\MenuItem\Service\ServiceInterface');
        
        $controllerService = $serviceLocator->get('Pacificnm\Controller\Service\ServiceInterface');
        
        return new Service($mapper, $resourceService, $roleService, $aclService, $menuService, $moduleService, $pageService, $menuItemService, $controllerService);
    }
}
