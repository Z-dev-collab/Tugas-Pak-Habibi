<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction_items extends Model
{
    protected $fillable = ['transaction_id', 'product_id', 'harga', 'qty', 'subtotal'];
}
