<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $fillable = ['kode', 'nama'];

    /**
     * Get all classrooms for this major
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
