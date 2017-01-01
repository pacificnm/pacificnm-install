<?php

namespace Pacificnm\Install\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CompleteController extends AbstractActionController
{
    /**
     * 
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        $this->layout('layout/install.phtml');
        
        return new ViewModel();
    }


}

