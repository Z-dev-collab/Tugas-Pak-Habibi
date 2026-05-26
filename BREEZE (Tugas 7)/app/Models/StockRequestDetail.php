<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequestDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_request_id',
        'item_id',
        'qty_requested',
        'qty_approved',
    ];

    public function stockRequest()
    {
        return $this->belongsTo(StockRequest::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
