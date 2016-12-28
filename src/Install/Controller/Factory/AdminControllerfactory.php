<?php
namespace Install\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Install\Controller\AdminController;
use Install\Form\AdminForm;

class AdminControllerfactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Install\Controller\AdminController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $authService = $realServiceLocator->get('Auth\Service\ServiceInterface');
        
        $configService = $realServiceLocator->get('Config\Service\ServiceInterface');
        
        $form = $realServiceLocator->get('Install\Form\AdminForm');
        
        return new AdminController($authService, $configService, $form);
    }
}
