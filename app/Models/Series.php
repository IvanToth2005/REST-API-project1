<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{

    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'title',
        'director_id',
        'release_date',
        'seasons',
        'description',
        'image',
        'type_id',
        'length',
        'created_at',
        'updated_at'
        
    ];
}
