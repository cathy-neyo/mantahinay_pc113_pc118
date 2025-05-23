<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    // use HasFactory;

       protected $fillable = [
        'name', 'scholarship_title', 'date_applied', 'status', 'phone_number'
    ];
}
