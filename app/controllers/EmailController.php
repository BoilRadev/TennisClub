<?php
class EmailController extends ControllerBase{

    public function sendEmailAction($toAddress, $subject , $body){

        $transport = new Swift_SmtpTransport('smtp.gmail.com',587,'tls');
        $transport->setUsername('boil.radev@gmail.com');
        $transport->setPassword('ebonwnoasnapupni');
        $transport->setStreamOptions(array('ssl'=>array('allow_self_singed' => true, 'verify_peer' => false)));

        $mailer = new Swift_Mailer($transport);

        $message = new Swift_Message($subject);
        $message->setFrom(['boil.radev@gmail.com' => 'Boil Radev']);
        $message->setTo([$toAddress,$toAddress=>$toAddress]);
        $message->setBody($body);

        $result = $mailer->send($message);
        if ($result>0){
            $this->flash->notice("Email sent successfully");
            $this->dispatcher->forward(["controller"=>"members" , "action" => "search"]);
        }
        else{
            $this->flash->notice("Email not sent successfully");
            $this->dispatcher->forward(["controller"=>"members" , "action" => "search"]);
        }
        $this->dispatcher->forward(["controller"=>"members" , "action" => "search"]);
    }

    public function testMailAction(){
        $this->sendEmailAction('boil.radev@delasport.com','Hi from Swift', 'Mail send successfully');
    }
}