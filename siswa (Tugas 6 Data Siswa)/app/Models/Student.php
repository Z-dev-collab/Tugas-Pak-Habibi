<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'major_id',
        'classroom_id',
        'alamat',
        'no_hp',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the major that this student belongs to
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    /**
     * Get the classroom that this student belongs to
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
