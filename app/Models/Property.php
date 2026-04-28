<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    // الحقول بتاعتك اللي بتستخدمها في الـ Form
    protected $fillable = ['name', 'city', 'type', 'price', 'image'];
    
    // "السلك" اللي بيوصلك بالفريق عشان الرسومات تشتغل
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
