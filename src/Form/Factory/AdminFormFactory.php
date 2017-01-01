<?php
namespace Install\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Install\Form\AdminForm;

class AdminFormFactory
{
    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Install\Form\AdminForm
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $roleService = $serviceLocator->get('AclRole\Service\ServiceInterface');
        
        return new AdminForm($roleService);
        
    }
}

