<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function stockRequests()
    {
        return $this->hasMany(StockRequest::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
