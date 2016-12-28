<?php

namespace Install\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CompleteController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layout('layout/install.phtml');
        
        return new ViewModel();
    }


}

