<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{

    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'title',
        'director_id',
        'release_date',
        'description',
        'image',
        'type_id',
        'length',
        'created_at',
        'updated_at'
        
    ];

    public function actors()
{
    return $this->belongsToMany(Actors::class, 'film_actor', 'film_id', 'actor_id')
                ->withPivot('is_lead')
                ->withTimestamps(); 
}

public function director()
{
    return $this->belongsTo(Directors::class, 'director_id');
}
}
