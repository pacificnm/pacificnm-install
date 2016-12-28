<?php
namespace Install\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Config\Config;
use Zend\Config\Writer\PhpArray;
use Install\Form\DatabaseForm;


class IndexController extends AbstractActionController
{

    public function __construct()
    {}

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        if(is_file('data/install')) {
            return $this->redirect()->toRoute('home');
        }
        
        
        $this->layout('layout/install.phtml');
        
        $form = new DatabaseForm();
        
        $configError = false;
        
        // test if we can write
        if (! is_writable('config/autoload/')) {
            $configError = true;
        }
        
        $request = $this->getRequest();
        
        // if we have a post
        if ($request->isPost()) {
            // get post
            $postData = $request->getPost();
            
            $form->setData($postData);
            
            // if we are valid
            if ($form->isValid()) {
                
                $data = $form->getData();
                
                $config = new Config(array(), true);
                
                $config->db = array();
                
                $config->db->username = $data['db1Username'];
                $config->db->password = $data['db1Password'];
                $config->db->dsn = 'mysql:dbname=' . $data['dbname'] . ';host=' . $data['db1Host'];
                $config->db->adapters = array();
                
                $config->db->adapters->db1 = array();
                $config->db->adapters->db1->dsn = 'mysql:dbname=' . $data['dbname'] . ';host=' . $data['db1Host'];
                $config->db->adapters->db1->username = $data['db1Username'];
                $config->db->adapters->db1->password = $data['db1Password'];
                $config->db->adapters->db1->driver = 'Pdo';
                
                $config->db->adapters->db2 = array();
                $config->db->adapters->db2->dsn = 'mysql:dbname=' . $data['dbname'] . ';host=' . $data['db1Host'];
                $config->db->adapters->db2->username = $data['db1Username'];
                $config->db->adapters->db2->password = $data['db1Password'];
                $config->db->adapters->db2->driver = 'Pdo';
                
                $config['encryption-key'] = '7eVzmBXQ63mehlO3';
                
                $writer = new PhpArray();
                
                $writer->toFile('config/autoload/local.php', $config);
                
                return $this->redirect()->toRoute('install-database');
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'configError' => $configError
        ));
    }
}

