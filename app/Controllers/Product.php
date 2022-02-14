<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Product extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $this->model->orderBy('id','DESC')->findAll()
        ],200);
    }

    public function show($id = null)
    {
        return $this->respond([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $this->model->find($id)
        ],200);
    }

    public function create()
    {
        if($this->request)
        {
            //get request from VueJS
            if($this->request->getJSON())
            {
                $json = $this->request->getJSON();
                $product = $this->model->insert([
                    'title' => $json->title,
                    'price' => $json->price
                ]);
            } 
            else
            {
                $product = $this->model->insert([
                    'title' => $this->request->getPost('title'),
                    'price' => $this->request->getPost('price')
                ]);
            }
        }

        return $this->respond([
            'statusCode' => 201,
            'message' => 'Data Berhasil Disimpan'
        ],201);
    }

    public function update($id = null)
    {
        //model 
        $product = $this->model;
        if($this->request)
        {
            //get request from VueJS
            if($this->request->getJSON())
            {
                $json = $this->request->getJSON();
                $product->model->insert([
                    'title' => $json->title,
                    'price' => $json->price
                ]);
            } 
            else
            {
               $data = $this->request->getRawInput();
               $product->update($id,$data);
            }
            return $this->respond([
                'statusCode' => 200,
                'message' => 'Data Berhasil diUpdate'
            ],200);
        }
    }

    public function delete($id = null)
    {
        $product = $this->model->find($id);
        if ($product) {
            $this->model->delete($id);

            return $this->respond([
                'statusCode' => 200,
                'message' => 'Data berhasil Dihapus'
            ],200);
        }
    }
}
