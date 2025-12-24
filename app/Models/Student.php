<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function getDisplayNameAttribute()
    {
        $name = $this->name;
        if ($this->participate_with === 'individual') {
            $name .= ' (Individual)';
        }
        return $name;
    }
}
