<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows convention)
    protected $table = 'payments';

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'price',
        'quantity',
        'total',
        'purchase_status',
        'status'
    ];

    // Optionally define a relationship with the User model (if needed)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
