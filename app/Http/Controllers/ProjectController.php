<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Property; 
use App\Models\Price;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    // 1. عرض لوحة التحكم
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->filled('city')) {
            $cleanCity = strtolower(trim($request->city));
            $query->where('city', $cleanCity);
        }

        if ($request->sort == 'newest') {
            $query->latest();
        } elseif ($request->sort == 'oldest') {
            $query->oldest();
        } elseif ($request->sort == 'alphabetical') {
            $query->orderBy('name', 'asc');
        }

        $properties = $query->get();
        $totalProjects = Project::count();
        $averagePrice = $query->avg('price') ?? 0; 

        return view('index', compact('properties', 'totalProjects', 'averagePrice'));
    }

    // 2. إضافة مشروع جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['city'] = strtolower(trim($request->city));

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            // رفع الصورة لمجلد public/uploads/projects
            $request->image->move(public_path('uploads/projects'), $imageName);
            // حل مشكلة المسار: إضافة / في البداية لضمان ظهور الصورة في الموقع
            $data['image'] = '/uploads/projects/' . $imageName;
        }

        // حفظ في جدولك الأساسي (الذي يشير أصلاً لجدول properties)
        $project = Project::create($data);

        // --- الربط مع جدول الأسعار عشان الرسومات تشتغل
        $project->prices()->create([
            'amount' => $request->price,
            'currency' => 'EGP'
        ]);

        return redirect()->back()->with('success', 'تم إضافة المشروع والصورة بنجاح!');
    }

    // 3. حذف مشروع (مع حذف صورته من السيرفر)
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        
        if ($project->image && File::exists(public_path($project->image))) {
            File::delete(public_path($project->image));
        }

        $project->delete();

        return redirect()->back()->with('success', 'تم حذف المشروع بنجاح!');
    }

    // 4. عرض صفحة التعديل
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('edit', compact('project'));
    }

    // 5. تحديث بيانات المشروع (مع معالجة الصورة الجديدة)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
        ]);

        $project = Project::findOrFail($id);
        $data = $request->all();
        $data['city'] = strtolower(trim($request->city));

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة لتوفير المساحة
            if ($project->image && File::exists(public_path($project->image))) {
                File::delete(public_path($project->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/projects'), $imageName);
            // تحديث المسار الصحيح
            $data['image'] = '/uploads/projects/' . $imageName;
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'تم تحديث البيانات والصورة بنجاح!');
    }
    
    // 6. الـ API الخاص بالتوقعات وسعر الدولار
    public function getProjectsApi(Request $request)
    {
        try {
            $response = Http::get("https://v6.exchangerate-api.com/v6/d5aeda4ca7b65e4ea882d7f9/latest/USD");
            $exchangeData = $response->json();
            $usdToEgp = $exchangeData['conversion_rates']['EGP'] ?? 54.3236; 

            $baseRate = 54.3236; 
            $marketFactor = $usdToEgp / $baseRate;
        } catch (\Exception $e) {
            $marketFactor = 1;
        }

        $query = Project::query();
        
        if ($request->filled('city')) {
            $cleanCity = strtolower(trim($request->city));
            $query->where('city', $cleanCity);
        }

        $projects = $query->get()->map(function($project) use ($marketFactor) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'city' => $project->city,
                'type' => $project->type,
                'original_price' => $project->price,
                'predicted_price' => round($project->price * $marketFactor),
                
                'image' => asset($project->image),
            ];
        });

        return response()->json($projects);
    }
}
