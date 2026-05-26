<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    protected $table = 'classroom';
    protected $fillable = ['nama', 'tingkat', 'major_id'];

    /**
     * Get the major that owns this classroom
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    /**
     * Get all students in this classroom
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
