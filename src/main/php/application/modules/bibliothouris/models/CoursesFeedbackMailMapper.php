<?php

class Bibliothouris_Model_CoursesFeedbackMailMapper extends Bibliothouris_Model_AbstractMapper {

    public function getDbTable() {
        if(null === $this->_dbTable) {
            $this->setDbTable('Bibliothouris_Model_DbTable_CoursesFeedbackMail');
        }
        return $this->_dbTable;
    }

    public function toArray($model) {
        if(!$model instanceof Bibliothouris_Model_CoursesFeedbackMail) {
            throw new Zend_Exception("Invalid parameter model");
        }

        $result = array(
            'id' => $model->getId(),
            'course_id' => $model->getCourseId(),
            'member_id' => $model->getMemberId(),
            'status' => $model->getStatus(),
            'created' => $model->getCreated(),
            'modified' => $model->getModified(),
        );

        return $result;
    }

    public function find($id) {
        if(!is_numeric($id)) {
            throw new Zend_Exception('Id is not set');
        }

        $result = $this->getDbTable()->find($id);
        if(0 == count($result)) {
            throw new Zend_Exception("Course Feedback Mail does not exist for id {$id}");
        }

        $row = $result->current();
        $model = new Bibliothouris_Model_CoursesFeedbackMail();

        $this->loadModel($row, $model);

        if(!$model instanceof  Bibliothouris_Model_CoursesFeedbackMail) {
            throw new Zend_Exception("Invalid Model");
        }
        return $model;
    }

    public function loadModel($data, &$entry = null) {

        if(!is_array($data) && !$data instanceof Zend_Db_Table_Row_Abstract && !$data instanceof stdClass) {
            throw new Zend_Exception("Invalid parameter data");
        }
        if(null !== $entry &&  !$entry instanceof Bibliothouris_Model_CoursesFeedbackMail) {
            throw new Zend_Exception("Invalid parameter entry");
        }

        if ($data instanceof Zend_Db_Table_Row_Abstract) {
            $data = $data->toArray();
        }
        if ($entry === null) {
            $entry = new Bibliothouris_Model_CoursesFeedbackMail();
        }

        $entry->setId($data['id'])
            ->setCourseId($data['course_id'])
            ->setMemberId($data['member_id'])
            ->setStatus($data['status'])
            ->setCreated($data['created'])
            ->setModified($data['modified']);

        return $entry;
    }

    public function processFeedbackMails(){
        $this->addFeedbackMailsToQueue();
        $this->sendFeedbackMails();
    }

    public function addFeedbackMailsToQueue(){
        $select = $this->getAdapter()->select()
            ->from( array('e' => 'enrollments'), array() )
            ->joinLeft( array('cfm' => 'courses_feedback_mail'), 'e.member_id=cfm.member_id AND e.course_id=cfm.course_id', array() )
            ->join( array('c' => 'courses'), 'c.id = e.course_id', array('course_id'=>'c.id','created'=>'now()','modified'=>'now()') )
            ->join( array('m' => 'members'), 'm.id = e.member_id', array('member_id'=>'m.id') )
            ->where('cfm.id IS NULL');

        $results = $this->getAdapter()->fetchAll($select);
        foreach($results as $result){
            $result['id'] = 0;
            $result['status'] = 0;
            $feedbackMailModel = $this->loadModel($result);
            $feedbackMailModel->getMapper()->getDbTable()->insert(
                $this->toArray($feedbackMailModel)
            );
        }

        return $results;
    }

    public function sendFeedbackMails(){
        $select = $this->getAdapter()->select()
            ->from( array('cfm' => 'courses_feedback_mail'), array('feedback_mail_id'=>'id') )
            ->join( array('c' => 'courses'), 'c.id = cfm.course_id', array('c.title') )
            ->join( array('m' => 'members'), 'm.id = cfm.member_id', array('m.fname','m.lname','name'=>'concat(m.fname,\' \',m.lname)','m.email') )
            ->where('cfm.status=0')
            ->limit(10);

        $mailModel = new Bibliothouris_Model_Mail();
        $results = $this->getAdapter()->fetchAll($select);

        foreach($results as $result){
            /*get mail body*/
            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout('email')->disableLayout();
            $layout->mailInfo = $result;
            $html = $layout->render();

            $mailFeed = array(
                'toAddress' => $result['email'],
                'toName'    => $result['name'],
                'subject'   => 'Bibliothouris feedback',
                'body'      => $html
            );

            $mailSent = $mailModel->sendGridMail($mailFeed);
            $feedbackMailModel = $this->find($result['feedback_mail_id']);
            $data = $this->toArray($feedbackMailModel);
            $data['status'] = ($mailSent === true)?1:2;

            $feedbackMailModel->getMapper()->getDbTable()->update(
                $data,array('id = ?'=>intval($result['feedback_mail_id']))
            );

        }

        return $results;
    }
}