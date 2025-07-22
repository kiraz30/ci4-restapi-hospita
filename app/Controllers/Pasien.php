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

        $data = $this->model->find($id);

        if (!$data){
            return $this->respond([
                'status' =>false,
                'message' => 'Data pasien tidak ditemukan',
                ], 404);
        }
        return $this->respond([
            'status' => true,
            'data' =>$data,
        ],200);
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
        //update data pasien by id
        if ($this->model->find($id) === null){
            return $this->respond([
                'status' =>false,
                'message' => 'Data pasien tidak ditemukan',
                ], 404);
        }

        $this->model->setValidationRule('nik','required|is_unique[pasien.nik,id,'.$id.']');
        $this->model->setValidationRule('no_hp','required|is_unique[pasien.no_hp,id,'.$id.']');
        $this->model->setValidationRule('email','required|is_unique[pasien.email,id,'.$id.']');
         
        $data = [
            'id' => $id,
            'nama_pasien' =>$this->request->getVar('nama_pasien'),
            'tanggal_lahir'=> $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'nik' => $this->request->getVar('nik'),
            'no_hp' => $this->request->getVar('no_hp'),
            'email' => $this->request->getVar('email'),
        ];

        if ($this->model->update($id, $data)){
            return $this->respond([
                'status'=> true,
                'message'=> 'Data pasien berhasil diupdate'
            ], 200);
        } else {
            return $this->respond([
                'status'=> false,
                'errors'=> $this->model->errors()
            ], 400);
        }
    }

   
    public function delete($id = null)
    {
        //delete data pasien
        if ($this->model->find($id) === null){
            return $this->respond([
                'status' =>false,
                'message' => 'Data pasien tidak ditemukan',
                ], 404);
        }
        $this->model->delete($id);
        return $this->respond([
            'status'=> true,
            'message'=> 'Data pasien berhasil dihapus'
        ], 200);

    }
}
