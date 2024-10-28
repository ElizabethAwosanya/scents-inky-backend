<?php

namespace App\Controllers;

use App\Models\Order;
use CodeIgniter\RESTful\ResourceController;

class OrderController extends ResourceController
{
    protected $modelName = 'App\Models\Order';
    protected $format    = 'json';

    // GET /orders - Fetch all orders
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // GET /orders/{id} - Fetch a single order by ID
    public function show($id = null)
    {
        $order = $this->model->find($id);
        if ($order) {
            return $this->respond($order);
        }
        return $this->failNotFound('Order not found');
    }

    // POST /orders - Create a new order
    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            $data['id'] = $this->model->insertID();
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // PUT /orders/{id} - Update an existing order
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respond($this->model->find($id));
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // DELETE /orders/{id} - Delete an order by ID
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Order deleted']);
        }
        return $this->failNotFound('Order not found');
    }
}
