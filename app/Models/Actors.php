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
   public function films()
{
    return $this->belongsToMany(Films::class, 'film_actor', 'actor_id', 'film_id')
                ->withPivot('is_lead')
                ->withTimestamps();
}

    
}
