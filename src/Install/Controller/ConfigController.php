<?php

namespace Install\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Config\Service\ServiceInterface;
use Config\Form\Form;


class ConfigController extends AbstractActionController
{

    /**
     *
     * @var ServiceInterface
     */
    protected $service;
    
    /**
     *
     * @var Form
     */
    protected $form;
    
    /**
     * 
     * @param ServiceInterface $service
     * @param Form $form
     */
    public function __construct(ServiceInterface $service, Form $form)
    {
        $this->service = $service;
        
        $this->form = $form;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        if(is_file('data/install')) {
            return $this->redirect()->toRoute('home');
        }
        
        
        $this->layout('layout/install.phtml');
        

        $configEntity = $this->service->get(1);
        
        $this->form->bind($configEntity);
        
        $request = $this->getRequest();
        
        // if we have a post
        if ($request->isPost()) {
            // get post
            $postData = $request->getPost();
        
            $this->form->setData($postData);
        
            // if we are valid
            if ($this->form->isValid()) {
        
                $entity = $this->form->getData();
        
                $this->service->save($entity);
        
                $this->flashmessenger()->addSuccessMessage('The config was saved');
        
                return $this->redirect()->toRoute('install-admin');
            }
        }
        
        // return view
        return new ViewModel(array(
            'form' => $this->form
        ));
    }


}

