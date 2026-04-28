<?php

use App\Models\Property;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;


// 1. عرض لوحة التحكم الرئيسية (Admin Dashboard)
Route::get('/', [ProjectController::class, 'index'])->name('projects.index');

// 2. مسار إضافة مشروع جديد
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

// 3. مسار حذف مشروع
Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

// 4. مسار عرض صفحة التعديل
Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');

// 5. مسار تحديث البيانات في قاعدة البيانات
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');

// 6. مسار الـ API الخاص بالبيانات (للفريق التاني)
Route::get('/api/projects-data', [ProjectController::class, 'getProjectsApi']);

// مسارات إضافية (اختياري)
Route::get('/cities', function () {
    return view('cities'); 
})->name('cities.index');

Route::get('/city-details/{id}', function ($id) {
    return view('city-details', ['id' => $id]);
})->name('city.details');

Route::get('/properties', function () {
    return Property::all();
});
