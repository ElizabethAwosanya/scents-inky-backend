<?php

namespace App\Controllers;

use App\Models\Product;
use CodeIgniter\RESTful\ResourceController;

class ProductsController extends ResourceController
{
    protected $modelName = 'App\Models\Product';
    protected $format    = 'json';

    // GET /products - Fetch all products
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // GET /products/{id} - Fetch a single product by ID
    public function show($id = null)
    {
        $product = $this->model->find($id);
        if ($product) {
            return $this->respond($product);
        }
        return $this->failNotFound('Product not found');
    }

    // POST /products - Create a new product
    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            $data['id'] = $this->model->insertID();
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // PUT /products/{id} - Update a product by ID
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respond($this->model->find($id));
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // DELETE /products/{id} - Delete a product by ID
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Product deleted']);
        }
        return $this->failNotFound('Product not found');
    }
}
