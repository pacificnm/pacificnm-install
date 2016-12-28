<?php
namespace Install\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Install\Controller\ConfigController;
use Config\Form\Form;

class ConfigControllerFactory
{

    /**
     *
     * @param ServiceLocatorInterface $serviceLocator            
     * @return \Install\Controller\ConfigController
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        
        $service = $realServiceLocator->get('Config\Service\ServiceInterface');
        
        $form = new Form();
        
        return new ConfigController($service, $form);
    }
}