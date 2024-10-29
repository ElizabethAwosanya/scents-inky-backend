<?php

namespace App\Controllers;

use App\Models\Product;
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
            $file->move(WRITEPATH . 'uploads', $imageName);
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
        $data = $this->request->getRawInput();

        // Check if there's a new image file
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $imageName);
            $data['image'] = $imageName;

            // Optional: delete old image file if needed
            $existingProduct = $this->model->find($id);
            if ($existingProduct && $existingProduct['image']) {
                $oldImage = WRITEPATH . 'uploads/' . $existingProduct['image'];
                if (is_file($oldImage)) {
                    unlink($oldImage);
                }
            }
        }

        if ($this->model->update($id, $data)) {
            $updatedProduct = $this->model->find($id);
            if ($updatedProduct['image']) {
                $updatedProduct['image_url'] = base_url('uploads/' . $updatedProduct['image']);
            }
            return $this->respond($updatedProduct);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // DELETE /products/{id} - Delete a product by ID
    public function delete($id = null)
    {
        $product = $this->model->find($id);
        if (!$product) {
            return $this->failNotFound('Product not found');
        }

        // Optional: delete the associated image file
        if ($product['image']) {
            $imagePath = WRITEPATH . 'uploads/' . $product['image'];
            if (is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Product deleted']);
        }
        return $this->fail('Failed to delete the product');
    }
}
