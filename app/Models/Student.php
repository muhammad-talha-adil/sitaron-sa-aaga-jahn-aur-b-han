<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_name',
        'name',
        'father',
        'dob',
        'age',
        'grade',
        'gender',
        'contact',
        'participation_id',
        'payment_receipt',
        'student_image',
    ];
}
