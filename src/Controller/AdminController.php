<?php
namespace Pacificnm\Install\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
use Pacificnm\Auth\Service\ServiceInterface as AuthServiceInterface;
use Pacificnm\Config\Service\ServiceInterface as ConfigServiceInterface;
use Pacificnm\Install\Form\AdminForm;
use Pacificnm\Auth\Entity\Entity;

class AdminController extends AbstractActionController
{

    /**
     *
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     *
     * @var ConfigServiceInterface
     */
    protected $configService;

    /**
     *
     * @var AdminForm
     */
    protected $form;

    public function __construct(AuthServiceInterface $authService, ConfigServiceInterface $configService, AdminForm $form)
    {
        $this->authService = $authService;
        
        $this->configService = $configService;
        
        $this->form = $form;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        if (is_file('data/install')) {
            return $this->redirect()->toRoute('home');
        }
        
        $this->layout('layout/install.phtml');
        
        $request = $this->getRequest();
        
        // if we have a post
        if ($request->isPost()) {
            // get post
            $postData = $request->getPost();
            
            $this->form->setData($postData);
            
            // if we are valid
            if ($this->form->isValid()) {
                $bcrypt = new Bcrypt();
                
                $entity = $this->form->getData();
                
                $entity->setAuthPassword($bcrypt->create($postData['authPassword']));
                
                $authEntity = $this->authService->save($entity);
                
                // set install file
                touch('data/install');
                
                $this->flashmessenger()->addSuccessMessage('Install completed');
                
                return $this->redirect()->toRoute('install-complete');
            }
        }
        
        
        $this->form->get('authId')->setValue(0);
        
        $this->form->get('authLastLogin')->setValue(time());
        
        $this->form->get('authLastIp')->setValue($_SERVER['REMOTE_ADDR']);
        
        // return array
        return new ViewModel(array(
            'form' => $this->form
        ));
    }
}

