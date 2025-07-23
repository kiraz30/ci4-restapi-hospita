<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;

class RegisterController extends BaseController
{
use ResponseTrait;
    
    public function index()
    {
       $rules = [
        'email' => [
            'rules' => 'required|valid_email|is_unique[users.email]',
        ],
        'password'=> [
            'rules' => 'required|min_length[6]',
            'errors' => [
                'required' => 'Password harus diisi',
                'min_length' => 'Password minimal 6 karakter'
            ],
        ],
        'confirm_password' => [
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Konfirmasi password harus diisi',
                'matches' => 'Konfirmasi password tidak cocok'
            ],
        ]
    ];
        if ($this->validate($rules)) {
            $userModel = new UsersModel();

            $userData = [
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            ];

            $userModel->save($userData);

            return $this->respond([
                'status'=>true,
                'message' => 'User registered successfully',
            ], 200);
        }
        else {
            $response = [
                'status' => false,
                'errors' => $this->validator->getErrors()
            ];
            return $this->respond($response, 500);
        }
    }

}
