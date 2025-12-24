<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $appends = [];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
