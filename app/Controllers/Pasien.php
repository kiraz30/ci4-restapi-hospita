<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PasienModel;

class Pasien extends ResourceController
{
    // init model
    protected $modelName = 'App\Models\PasienModel';

    public function index()
    {
        //get all data pasien
        $pasienModel = new PasienModel();

        return $this->respond([
            'status'=> true,
            'data'=> $pasienModel->findAll()

        ], 200);

    }

    public function show($id = null)
    {
        //get date by id
    }

  
    public function create()
    {
        //add data pasien
        $data = [
            'nama_pasien' =>$this->request->getVar('nama_pasien'),
            'tanggal_lahir'=> $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'nik' => $this->request->getVar('nik'),
            'no_hp' => $this->request->getVar('no_hp'),
            'email' => $this->request->getVar('email'),
        ];

        $pasienModel = new PasienModel();
        if ($this->model->save($data)){
            return $this->respond([
                'status'=> true,
                'message'=> 'Data pasien berhasil disimpan'
            ], 200);
        } else {
            return $this->respond([
                'status'=> false,
                'errors'=> $this->model->errors()
            ], 400);
        }
        

      
    }

 
    public function update($id = null)
    {
        //update data pasien
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //delete data pasien
    }
}
