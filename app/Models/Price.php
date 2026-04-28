<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    // 1. الجدول اللي الفريق التاني عمله
    protected $table = 'prices';

    // 2. الحقول بتاعتك وبتاعتهم عشان الـ Form والـ API يشتغلوا
    protected $fillable = ['property_id', 'amount', 'currency', 'created_at'];

    // 3. علاقة الفريق التاني (عشان الـ Charts والـ Forecast)
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // 4. العلاقة بتاعتك إنت (عشان الـ CRUD بتاعك يفضل سليم)
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
