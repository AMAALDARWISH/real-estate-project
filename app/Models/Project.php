<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "properties";
    
    protected $fillable = ['name', 'city', 'type', 'price', 'image'];
    
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
    
}
