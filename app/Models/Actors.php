<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actors extends Model
{

    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'name',
        'image',
        'created_at',
        'updated_at'
        
    ];
}
