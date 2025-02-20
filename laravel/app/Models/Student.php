<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    
    protected $fillable = [
        'firstname',
        'lastname',
        'age',
        'gender',
        'address',
        'email',
        'contact_number',
        'course',
    ];
}