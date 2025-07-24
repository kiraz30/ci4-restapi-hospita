<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class SendEmail extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $email_dest = $this->request->getVar("email_dest");
        $subject = $this->request->getVar("subject");
        $message = $this->request->getVar("message");


        $email = service('email');
        $email->setTo($email_dest);
        $email->setFrom('admin@hospital.com', 'Hospital Admin');

        $email->setSubject($subject);
        $email->setMessage($message);

        if($email->send()){
            return $this->respond([
                'status'=>true,
                'message' => 'Email sent successfully',
            ], 200);
        }else{
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }

    }
}
