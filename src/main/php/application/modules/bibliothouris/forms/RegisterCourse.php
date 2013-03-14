<?php
class Bibliothouris_Form_RegisterCourse extends Zend_Form {

    public function init() {

        $this->setAttribs(array('class' => 'form block-labels', 'id' => 'registerForm'))
            ->setMethod('post');

        $element = new Zend_Form_Element_Text('title');
        $element->setLabel('Course Title')
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

        $element = new Zend_Form_Element_Text('date_start');
        $element->setLabel('Date Start')
            ->setAttrib('class', 'fieldsClass')
            ->setAttrib('readonly', 'readonly')
            ->setAttrib('autocomplete', 'off')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'))
            ->removeDecorator('Errors');
        $this->addElement($element);

        $element = new Zend_Form_Element_Text('date_end');
        $element->setLabel('Date End')
            ->setAttrib('class', 'fieldsClass')
            ->setAttrib('readonly', 'readonly')
            ->setAttrib('autocomplete', 'off')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_Date('YYYY-MM-DD'))
            ->addValidator(new Bibliothouris_Validate_DateEnd())
            ->removeDecorator('Errors');
        $this->addElement($element);

        $element = new Zend_Form_Element_Text('trainer_name');
        $element->setLabel('Trainer Name')
            ->setAttrib('class', 'fieldsClass')
            ->setAttrib('maxlength', 50)
            ->setRequired(true)
            ->removeDecorator('Errors');
        $this->addElement($element);

        $element = new Zend_Form_Element_Textarea('content');
        $element->setLabel('Contents')
                ->setAttrib('class', 'textAreaContents')
                ->removeDecorator('Errors');
        $this->addElement($element);

        $element = new Zend_Form_Element_Submit('registerCourseSbt');
        $element->setLabel('Register')
            ->setAttrib('class', 'buttons');
        $this->addElement($element);

        $element = new Zend_Form_Element_Reset('registerCourseCancel');
        $element->setLabel('Cancel')
            ->setAttrib('class', 'buttons')
            ->setAttrib('onclick', 'location.href=\'/bibliothouris/courses/index\'');
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
class Bibliothouris_Validate_DateEnd extends Zend_Validate_Abstract {

    const ERROR_DATE = '';

    protected $_messageTemplates = array(
        self::ERROR_DATE => "Date start can not be greater than date end"
    );

    public function isValid($value, $context = null) {
        $timestampStart = strtotime($context['date_start']);
        $timestampEnd = strtotime($context['date_end']);

        if($timestampStart > $timestampEnd){
            $this->_error(self::ERROR_DATE);
            return false;
        }
        return true;
    }

}
