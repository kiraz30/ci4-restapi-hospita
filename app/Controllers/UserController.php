<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Firebase\JWT\JWT;

class UserController extends BaseController
{

    use ResponseTrait;
    public function register()
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


    public function login(){
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $userModel = new UsersModel();
        $user = $userModel->where('email', $email)->first();

        if(!$user){
            $response = [
                'status' => false,
                'message' => 'Email tidak sesuai',
            ];
            return $this->respond($response, 401);
        }

        if(!password_verify($password, $user['password'])){
            $response = [
                'status' => false,
                'message' => 'Password tidak sesuai',
            ];
            return $this->respond($response, 401);
        }

        //generate JWT token

        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + (1*60);
        $payload = [
            'iss' => 'resapi-hospital', //penerbit jwt 
            'iat' => $iat,
            'exp' => $exp, 
            'sub' => 'maketoken', //subject
            'email' => $email, // save email
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respond([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $token,
        ], 200);
    }


    public function getProfile($id = null)
    { 
    
        $userModel = new UsersModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->respond([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        return $this->respond([
            'status' => true,
            'data' => $user,
        ], 200);
    }

    
    public function editProfile($id = null)
    { 
    
        $userModel = new UsersModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->respond([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        return $this->respond([
            'status' => true,
            'data' => $user,
        ], 200);
    }
}
