<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Price;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // مسح البيانات القديمة لتجنب التكرار أو التضارب
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Property::truncate();
        Price::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // مصفوفة البيانات كاملة كما هي في ملف الـ JS الخاص بكِ
        $governorates = [
            ['id' => 'cairo', 'name' => 'القاهرة', 'city' => 'Cairo', 'min' => 2600000, 'max' => 14000000],
            ['id' => 'giza', 'name' => 'الجيزة', 'city' => 'Giza', 'min' => 2200000, 'max' => 16000000],
            ['id' => 'alexandria', 'name' => 'الإسكندرية', 'city' => 'Alexandria', 'min' => 1800000, 'max' => 9500000],
            ['id' => 'dakahlia', 'name' => 'الدقهلية', 'city' => 'Dakahlia', 'min' => 1400000, 'max' => 6200000],
            ['id' => 'red-sea', 'name' => 'البحر الأحمر', 'city' => 'Red Sea', 'min' => 3000000, 'max' => 18000000],
            ['id' => 'beheira', 'name' => 'البحيرة', 'city' => 'Beheira', 'min' => 1100000, 'max' => 4500000],
            ['id' => 'fayoum', 'name' => 'الفيوم', 'city' => 'Fayoum', 'min' => 950000, 'max' => 3800000],
            ['id' => 'gharbia', 'name' => 'الغربية', 'city' => 'Gharbia', 'min' => 1300000, 'max' => 5200000],
            ['id' => 'ismailia', 'name' => 'الإسماعيلية', 'city' => 'Ismailia', 'min' => 1500000, 'max' => 7000000],
            ['id' => 'monufia', 'name' => 'المنوفية', 'city' => 'Monufia', 'min' => 1250000, 'max' => 5000000],
            ['id' => 'minya', 'name' => 'المنيا', 'city' => 'Minya', 'min' => 1000000, 'max' => 4600000],
            ['id' => 'qalyubia', 'name' => 'القليوبية', 'city' => 'Qalyubia', 'min' => 1700000, 'max' => 8000000],
            ['id' => 'new-valley', 'name' => 'الوادي الجديد', 'city' => 'New Valley', 'min' => 850000, 'max' => 3200000],
            ['id' => 'suez', 'name' => 'السويس', 'city' => 'Suez', 'min' => 1800000, 'max' => 12000000],
            ['id' => 'aswan', 'name' => 'أسوان', 'city' => 'Aswan', 'min' => 1300000, 'max' => 5500000],
            ['id' => 'assiut', 'name' => 'أسيوط', 'city' => 'Assiut', 'min' => 1200000, 'max' => 5200000],
            ['id' => 'beni-suef', 'name' => 'بني سويف', 'city' => 'Beni Suef', 'min' => 1000000, 'max' => 4300000],
            ['id' => 'port-said', 'name' => 'بورسعيد', 'city' => 'Port Said', 'min' => 1700000, 'max' => 6200000],
            ['id' => 'damietta', 'name' => 'دمياط', 'city' => 'Damietta', 'min' => 1500000, 'max' => 7500000],
            ['id' => 'sharqia', 'name' => 'الشرقية', 'city' => 'Sharqia', 'min' => 1400000, 'max' => 6500000],
            ['id' => 'south-sinai', 'name' => 'جنوب سيناء', 'city' => 'South Sinai', 'min' => 2800000, 'max' => 20000000],
            ['id' => 'kafr-el-sheikh', 'name' => 'كفر الشيخ', 'city' => 'Kafr El Sheikh', 'min' => 1100000, 'max' => 4200000],
            ['id' => 'matrouh', 'name' => 'مطروح', 'city' => 'Matrouh', 'min' => 3200000, 'max' => 22000000],
            ['id' => 'luxor', 'name' => 'الأقصر', 'city' => 'Luxor', 'min' => 1400000, 'max' => 6500000],
            ['id' => 'qena', 'name' => 'قنا', 'city' => 'Qena', 'min' => 1000000, 'max' => 4300000],
            ['id' => 'north-sinai', 'name' => 'شمال سيناء', 'city' => 'North Sinai', 'min' => 1200000, 'max' => 5000000],
            ['id' => 'sohag', 'name' => 'سوهاج', 'city' => 'Sohag', 'min' => 950000, 'max' => 4000000],
        ];

        $propertyTypes = ["شقة", "فيلا", "دوبلكس", "تاون هاوس", "بنتهاوس"];

        // قائمة الصور
        $propertyImagePool = [
            "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1605146769289-440113cc3d00?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600566752355-35792bedcfea?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600047509358-9dc75507daeb?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600607687644-c7171b42498f?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600607687126-8a3414349a51?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600573472591-ee6b68d14c68?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1501183638710-841dd1904471?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1460317442991-0ec209397118?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1448630360428-65456885c650?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1505692952047-1a78307da8f2?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80"
        ];

        foreach ($governorates as $gov) {
            for ($i = 1; $i <= 12; $i++) {
                $randomPrice = rand($gov['min'], $gov['max']);
                // السطر 88 تم تعديله هنا ليكون رقمياً بحتاً
                $imageIndex = ($i % count($propertyImagePool)); 
                
                // إنشاء العقار
                $property = Property::create([
                    'name'  => "مشروع العقارات بـ " . $gov['name'] . " " . $i,
                    'city'  => $gov['name'], 
                    'type'  => $propertyTypes[array_rand($propertyTypes)],
                    'price' => $randomPrice,
                    'image' => $propertyImagePool[$imageIndex],
                    'created_at' => now()->subMonths(rand(0, 24)), 
                ]);

                // إدخال السعر في جدول الأسعار
                Price::create([
                    'property_id' => $property->id,
                    'amount' => $randomPrice,
                    'created_at' => $property->created_at,
                ]);
            }
        }

        $this->command->info('تم إدخال جميع بيانات الـ 27 محافظة مع أسعارها بنجاح!');
    }
}