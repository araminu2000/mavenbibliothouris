<?php
class Bibliothouris_Form_LoginMember extends Zend_Form {

    public function init() {

        $this->setAttribs(array('class' => 'form block-labels', 'id' => 'loginForm'))
             ->setMethod('post');

        $element = new Zend_Form_Element_Text('email');
        $element->setLabel('Email')
            ->setAttrib('class', 'fieldsClass')
            ->setAttrib('maxlength', 50)
            ->setRequired(true)
            ->setValidators(array(
            array(
                'validator' => 'StringLength',
                'options' => array(1, 50),

            )
        ))
            ->removeDecorator('Errors');
        $this->addElement($element);

        $element = new Zend_Form_Element_Password('password');
        $element->setLabel('Password')
            ->setAttrib('class', 'fieldsClass')
            ->setAttrib('autocomplete', 'off')
            ->setRequired(true)
            ->removeDecorator('Errors');
        $this->addElement($element);


        $element = new Zend_Form_Element_Submit('loginMember');
        $element->setLabel('Login')
                ->setAttrib('class', 'buttons');
        $this->addElement($element);
    }

    public function setPrevalidation() {
        $request = Zend_Controller_Front::getInstance()->getRequest()->getPost();
        if(!empty($request)){
            $this->isValid($request);
        }
        $errFields = array_keys($this->getMessages());
        foreach($errFields as $errField){
            $element =$this->getElement($errField);
            if(!empty($element)){
                $element->setAttrib('class', $element->getAttrib('class') . ' errorField');
            }
        }
    }
}