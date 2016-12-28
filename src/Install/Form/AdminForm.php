<?php
namespace Install\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Auth\Hydrator\Hydrator;
use Auth\Entity\Entity;
use AclRole\Service\ServiceInterface as RoleServiceInterface;

class AdminForm extends Form implements InputFilterProviderInterface
{

    /**
     *
     * @var RoleServiceInterface
     */
    protected $roleService;

    /**
     *
     * @param RoleServiceInterface $roleService            
     * @param string $name            
     * @param array $options            
     * @return \Install\Form\AdminForm
     */
    function __construct(RoleServiceInterface $roleService, $name = 'admin-form', $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setHydrator(new Hydrator(false));
        
        $this->setObject(new Entity());
        
        $this->roleService = $roleService;
        
        // authId
        $this->add(array(
            'name' => 'authId',
            'type' => 'hidden'
        ));
        
        // aclRoleId
        $this->add(array(
            'type' => 'Select',
            'name' => 'aclRoleId',
            'options' => array(
                'label' => 'Role:',
                'value_options' => $this->getRoleOptions()
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'aclRoleId'
            )
        ));
        
        // authEmail
        $this->add(array(
            'name' => 'authEmail',
            'type' => 'Text',
            'options' => array(
                'label' => 'E-Mail:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'authEmail'
            )
        ));
        
        // authPassword
        $this->add(array(
            'name' => 'authPassword',
            'type' => 'Text',
            'options' => array(
                'label' => 'Password:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'authPassword'
            )
        ));
        
        // authName
        $this->add(array(
            'name' => 'authName',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'authName'
            )
        ));
        
        // authLastLogin
        $this->add(array(
            'name' => 'authLastLogin',
            'type' => 'hidden'
        ));
        
        // authLastIp
        $this->add(array(
            'name' => 'authLastIp',
            'type' => 'hidden'
        ));
        
        // button
        $this->add(array(
            'name' => 'submit',
            'type' => 'button',
            'attributes' => array(
                'value' => 'Submit',
                'id' => 'submit',
                'class' => 'btn btn-primary btn-flat'
            )
        ));
        
        return $this;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Zend\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     */
    public function getInputFilterSpecification()
    {
        return array(
            // authId
            'authId' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Auth Id is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            
            // aclRoleId
            'aclRoleId' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Auth Role is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            
            // authEmail
            'authEmail' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Auth E-Mail is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            
            // authPassword
            'authPassword' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'break_chain_on_failure' => true,
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Auth Password is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            
            
            
            
            
        );
    }
    
    /**
     * 
     * @return NULL[]
     */
    protected function getRoleOptions()
    {
        $options = array();
        
        $entitys = $this->roleService->getAll(array('pagination' => 'off'));
        
        foreach($entitys as $entity) {
            $options[$entity->getAclRoleId()] = $entity->getAclRoleName();
        }
        
        return $options;
    }
}
