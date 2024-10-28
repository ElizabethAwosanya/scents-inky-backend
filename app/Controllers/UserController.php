<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $modelName = 'App\Models\User';
    protected $format    = 'json';

    // GET /users - Fetch all users
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // GET /users/{id} - Fetch a single user by ID
    public function show($id = null)
    {
        $user = $this->model->find($id);
        if ($user) {
            return $this->respond($user);
        }
        return $this->failNotFound('User not found');
    }

    // POST /users - Create a new user
    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            $data['id'] = $this->model->insertID();
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // PUT /users/{id} - Update an existing user
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respond($this->model->find($id));
        }
        return $this->failValidationErrors($this->model->errors());
    }

    // DELETE /users/{id} - Delete a user by ID
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'User deleted']);
        }
        return $this->failNotFound('User not found');
    }
}
