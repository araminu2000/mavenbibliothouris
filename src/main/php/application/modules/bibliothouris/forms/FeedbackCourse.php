<?php
class Bibliothouris_Form_FeedbackCourse extends Zend_Form {
    public $disableEnrollment = false;

    public function init() {

        $this->setAttribs(array('class' => 'form block-labels', 'id' => 'feedbackForm'))
            ->setMethod('post');


        $element = new Zend_Form_Element_Radio('score_trainer');
        $element->setLabel('Trainer')
            ->setAttrib('class', 'radioClass')
            ->setRequired(true)
            ->removeDecorator('Errors')
            ->addMultiOptions(array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
              ))
            ->setSeparator('');
        $this->addElement($element);

        $element = new Zend_Form_Element_Radio('score_location_infrastructure');
        $element->setLabel('Location & Infrastructure')
            ->setAttrib('class', 'radioClass')
            ->setRequired(true)
            ->removeDecorator('Errors')
            ->addMultiOptions(array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
        ))
            ->setSeparator('');
        $this->addElement($element);

        $element = new Zend_Form_Element_Radio('score_documentation');
        $element->setLabel('Documentation')
            ->setAttrib('class', 'radioClass')
            ->setRequired(true)
            ->removeDecorator('Errors')
            ->addMultiOptions(array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
        ))
            ->setSeparator('');
        $this->addElement($element);

        $element = new Zend_Form_Element_Radio('score_recommend');
        $element->setLabel('Would you recommend it')
            ->setAttrib('class', 'radioClass')
            ->setRequired(true)
            ->removeDecorator('Errors')
            ->addMultiOptions(array(
            '0' => 'No',
            '1' => 'Yes',
        ))
            ->setSeparator('');
        $this->addElement($element);

        $element = new Zend_Form_Element_Textarea('score_content');
        $element->setLabel('General feedback')
                ->setAttrib('class', 'textAreaContents')
                ->setRequired(true)
                ->removeDecorator('Errors');
        $this->addElement($element);

        $element = new Zend_Form_Element_Hidden('course_id');
        $element->removeDecorator('Errors');
        $this->addElement($element);

        $element = new Zend_Form_Element_Submit('registerCourseSbt');
        $element->setLabel('Register')
            ->setAttrib('class', 'buttons_second cancel');
        $this->addElement($element);

        $element = new Zend_Form_Element_Reset('registerCourseCancel');
        $element->setLabel('Cancel')
            ->setAttrib('class', 'buttons_second register')
            ->setAttrib('onclick', 'location.href=\'/bibliothouris/courses/index\'');
        $this->addElement($element);
    }

    public function setPrevalidation() {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $params = $request->getParams();
        if(!empty($params)){
            $this->isValid($params);
        }
        if($request->isPost()){
            $errFields = array_keys($this->getMessages());
            foreach($errFields as $errField){
                $element =$this->getElement($errField);
                if(!empty($element)){
                    $element->setAttrib('class', $element->getAttrib('class') . ' errorRadio');
                }
            }
        }
        $element = $this->_elements['course_id'];
        $element->setAttrib('value',$params['course_id']);
    }
}

