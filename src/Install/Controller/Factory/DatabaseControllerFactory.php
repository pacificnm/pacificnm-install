<?php
namespace Install\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Install\Controller\DatabaseController;

class DatabaseControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Install\Controller\DatabaseController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Install\Service\ServiceInterface');
        
        $config = $realServiceLocator->get('config');
        
        return new DatabaseController($service, $config);
    }
}
