<?php
namespace Install\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Config\Hydrator\Hydrator;
use Config\Entity\Entity;


class ConfigForm extends Form implements InputFilterProviderInterface
{
    
    /**
     * 
     * @param string $name
     * @param array $options
     * @return \Install\Form\ConfigForm
     */
    function __construct($name = 'config-form', $options = array())
    {
        parent::__construct($name, $options);
    
        $this->setHydrator(new Hydrator(false));
    
        $this->setObject(new Entity());
    
        // configId
        $this->add(array(
            'name' => 'configId',
            'type' => 'hidden'
        ));
    
        // configVersion
        $this->add(array(
            'name' => 'configVersion',
            'type' => 'hidden'
        ));
    
        // configCopyYear
        $this->add(array(
            'name' => 'configCopyYear',
            'type' => 'Text',
            'options' => array(
                'label' => 'Copyright Year:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCopyYear'
            )
        ));
    
        // configCompanyName
        $this->add(array(
            'name' => 'configCompanyName',
            'type' => 'Text',
            'options' => array(
                'label' => 'Company Full Name:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyName'
            )
        ));
    
        // configCompanyNameShort
        $this->add(array(
            'name' => 'configCompanyNameShort',
            'type' => 'Text',
            'options' => array(
                'label' => 'Company Short Name:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyNameShort'
            )
        ));
    
        // configCompanyNameAbv
        $this->add(array(
            'name' => 'configCompanyNameAbv',
            'type' => 'Text',
            'options' => array(
                'label' => 'Company Abbreviation:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyNameAbv'
            )
        ));
    
        // configCompanyStreet
        $this->add(array(
            'name' => 'configCompanyStreet',
            'type' => 'Text',
            'options' => array(
                'label' => 'Street:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyStreet'
            )
        ));
    
        // configCompanyStreetCont
        $this->add(array(
            'name' => 'configCompanyStreetCont',
            'type' => 'Text',
            'options' => array(
                'label' => 'Street Cont:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyStreetCont'
            )
        ));
    
    
        // configCompanyCity
        $this->add(array(
            'name' => 'configCompanyCity',
            'type' => 'Text',
            'options' => array(
                'label' => 'City:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyCity'
            )
        ));
    
        // configCompanyState
        $this->add(array(
            'name' => 'configCompanyState',
            'type' => 'Text',
            'options' => array(
                'label' => 'State:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyState'
            )
        ));
    
        // configCompanyPostal
        $this->add(array(
            'name' => 'configCompanyPostal',
            'type' => 'Text',
            'options' => array(
                'label' => 'Postal Code:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyPostal'
            )
        ));
    
        // configCompanyPhone
        $this->add(array(
            'name' => 'configCompanyPhone',
            'type' => 'Text',
            'options' => array(
                'label' => 'Phone Number:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyPhone'
            )
        ));
    
        // configCompanyPhoneAlt
        $this->add(array(
            'name' => 'configCompanyPhoneAlt',
            'type' => 'Text',
            'options' => array(
                'label' => 'Alternate Phone Number:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'configCompanyPhoneAlt'
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
     * {@inheritDoc}
     * @see \Zend\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     */
    public function getInputFilterSpecification()
    {
        return array(
            // configCompanyName
            'configCompanyName' => array(
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
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Company Full Name is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
            //configCompanyNameShort
            'configCompanyNameShort' => array(
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
                                \Zend\Validator\NotEmpty::IS_EMPTY => "The Company Short Name is required and cannot be empty."
                            )
                        )
                    )
                )
            ),
        );
        
    }

}
