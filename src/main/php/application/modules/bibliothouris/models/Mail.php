<?php

class Bibliothouris_Model_Mail {

    private $_mailInfo;

    public function __construct(){
        $this->_mailInfo = array(
            'username' => 'app13145255@heroku.com',
            'password' => 'qy93c8x2',
            'smtpServer'=> 'smtp.sendgrid.net',
            'defaultFromAddress' => 'info@bibliothouris.com',
            'defaultFromName' => 'Bibliothouris',
            'defaultSubject' => 'Bibliothouris Info'
        );
    }

    public function sendGridMail(array $data=null){
        require_once 'Zend/Mail.php';
        require_once 'Zend/Mail/Transport/Smtp.php';

        $config = array('ssl' => 'tls',
            'port' => '587',
            'auth' => 'login',
            'username' => $this->_mailInfo['username'],
            'password' => $this->_mailInfo['password']
        );

        $data['fromAddress'] = (empty($data['fromAddress']) || filter_var($data['fromAddress'], FILTER_VALIDATE_EMAIL) === false)?$this->_mailInfo['defaultFromAddress']:$data['fromAddress'];
        $data['fromName'] = empty($data['fromName'])?$this->_mailInfo['defaultFromName']:$data['fromName'];
        $data['subject'] = empty($data['subject'])?$this->_mailInfo['defaultSubject']:$data['subject'];
        $data['toName'] = empty($data['toName'])?$data['toAddress']:$data['toName'];


        if(filter_var($data['toAddress'], FILTER_VALIDATE_EMAIL) === false
          || empty($data['body'])){
            return false;
        }

        $transport = new Zend_Mail_Transport_Smtp($this->_mailInfo['smtpServer'], $config);
        $mail = new Zend_Mail();

        /*HACK : mails to arrive only to araminu2000@yahoo.com*/
        $data['toAddress'] = 'araminu2000@yahoo.com';
        /*********************************************************/

        $mail->setFrom($data['fromAddress'], $data['fromName']);
        $mail->addTo($data['toAddress'],$data['toName']);
        $mail->setSubject($data['subject']);
        $mail->setBodyHTML($data['body']);

        $mail->send($transport);

        return true;

    }
}
