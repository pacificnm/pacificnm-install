<?php
namespace Install\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class DatabaseForm extends Form implements InputFilterProviderInterface
{

    function __construct($name = 'labor-form', $options = array())
    {
        parent::__construct($name, $options);
    
        // dbname
        $this->add(array(
            'name' => 'dbname',
            'type' => 'Text',
            'options' => array(
                'label' => 'Database:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'dbname'
            )
        ));
        
        // db1Host
        $this->add(array(
            'name' => 'db1Host',
            'type' => 'Text',
            'options' => array(
                'label' => 'Host:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'db1Host'
            )
        ));
        
       
        
        // db1Username
        $this->add(array(
            'name' => 'db1Username',
            'type' => 'Text',
            'options' => array(
                'label' => 'Username:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'db1Username'
            )
        ));
        
       
        // db1Password
        $this->add(array(
            'name' => 'db1Password',
            'type' => 'Text',
            'options' => array(
                'label' => 'Password:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'db1Password'
            )
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
     * {@inheritDoc}
     *
     * @see \Zend\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     */
    public function getInputFilterSpecification()
    {
        return array(
            // dbname
            'dbname' => array(
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
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Database Name is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            
            // db1Host
            'db1Host' => array(
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
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Write Host is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            
            // db1Username
            'db1Username' => array(
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
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Write Username is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            
            // db1Password
            'db1Password' => array(
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
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Write Password is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            
           
        );
    }
}
