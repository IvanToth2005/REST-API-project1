<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directors extends Model
{

    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
        
    ];

     public function films()
    {
        return $this->hasMany(Films::class, 'director_id');
    }
}
