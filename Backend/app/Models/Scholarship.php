<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'title',
        'description',
        'amount',
        'start_date',   
        'end_date',
        'requirements',
        'image'
    ];
}

