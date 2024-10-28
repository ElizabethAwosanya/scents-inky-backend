<?php

namespace App\Models;

use CodeIgniter\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'total_price', 'status'];
    protected $useTimestamps = true;

    // Optionally, define validation rules for order data
    protected $validationRules = [
        'user_id' => 'required|integer',
        'total_price' => 'required|decimal',
        'status' => 'in_list[pending,completed,canceled]',
    ];
}
