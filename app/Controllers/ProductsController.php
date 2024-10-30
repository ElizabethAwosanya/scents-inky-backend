<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ProductsController extends ResourceController
{
    protected $modelName = 'App\Models\Product';
    protected $format = 'json';

    // GET /products - Fetch all products
    public function index()
    {
        $products = $this->model->findAll();
        foreach ($products as &$product) {
            if ($product['image']) {
                $product['image_url'] = base_url('uploads/' . $product['image']);
            }
        }
        return $this->respond($products);
    }

    // GET /products/{id} - Fetch a single product by ID
    public function show($id = null)
    {
        $product = $this->model->find($id);
        if ($product) {
            if ($product['image']) {
                $product['image_url'] = base_url('uploads/' . $product['image']);
            }
            return $this->respond($product);
        }
        return $this->failNotFound('Product not found');
    }

    // POST /products - Create a new product with image upload
    public function create()
    {
        $data = $this->request->getPost();

        // Handle image upload if provided
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $imageName); // Move file to 'uploads' folder in the public directory
            $data['image'] = $imageName;
        }

        if ($this->model->insert($data)) {
            $data['id'] = $this->model->insertID();
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // PUT /products/{id} - Update a product by ID with image upload
   
    public function update($id = null)
    {
        log_message('debug', 'PUT request received at update method.');
    
        // Retrieve form data
        $data = $this->request->getPost();
    
        if (empty($data)) {
            log_message('error', 'No post data received');
            return $this->failValidationErrors('No data to update.');
        }
    
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $imageName);
            $data['image'] = $imageName;
        }
    
        if ($this->model->update($id, $data)) {
            $updatedProduct = $this->model->find($id);
            $updatedProduct['image_url'] = base_url('uploads/' . $updatedProduct['image']);
            return $this->respond($updatedProduct);
        }
    
        log_message('error', 'Failed to update the product');
        return $this->failValidationErrors('Failed to update the product.');
    }
    

    // DELETE /products/{id} - Delete a product by ID
    public function delete($id = null)
    {
        $product = $this->model->find($id);
        if (!$product) {
            return $this->failNotFound('Product not found');
        }

        // Delete the associated image file if it exists
        if ($product['image']) {
            $imagePath = FCPATH . 'uploads/' . $product['image'];
            if (is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Product deleted']);
        }
        return $this->fail('Failed to delete the product');
    }

    public function optionsHandler()
    {
        return $this->response
            ->setStatusCode(200)
            ->setHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->setHeader('Access-Control-Allow-Credentials', 'true');
    }

    public function testUpload()
    {
        $file = $this->request->getFile('image');
        $data = $this->request->getPost();

        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $imageName);
            return $this->respond(['status' => 'success', 'image' => $imageName, 'data' => $data]);
        }

        return $this->fail('File not uploaded');
    }
}
