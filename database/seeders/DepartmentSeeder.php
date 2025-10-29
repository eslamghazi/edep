<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'قسم التمريض', 'name_en' => 'Nursing Department'],
            ['name' => 'قسم طب الطيران', 'name_en' => 'Aviation Medicine'],
            ['name' => 'قسم طب العلاج بالاوكسجين', 'name_en' => 'Oxygen Therapy'],
            ['name' => 'قسم الاشعة', 'name_en' => 'Radiology Department'],
            ['name' => 'مكتب المساعد للشؤون الصحية', 'name_en' => 'Assistant Office for Health Affairs'],
            ['name' => 'المساعد للشؤون الاكاديمية والتدريب', 'name_en' => 'Assistant for Academic Affairs and Training'],
            ['name' => 'قسم التعليم', 'name_en' => 'Education Department'],
            ['name' => 'قسم التدريب الفسيولوجي', 'name_en' => 'Physiological Training'],
            ['name' => 'مدير المركز الطبي الجوي', 'name_en' => 'Aviation Medical Center Director'],
            ['name' => 'مدير عام الادارة العامة للخدمات الطبية', 'name_en' => 'General Manager of Medical Services'],
            ['name' => 'وحدة المراجعة الداخلية', 'name_en' => 'Internal Audit Unit'],
            ['name' => 'ادارة التشغيل والصيانة', 'name_en' => 'Operations and Maintenance'],
            ['name' => 'ادارة تطوير الجودة وسلامة المرضى', 'name_en' => 'Quality Development and Patient Safety'],
            ['name' => 'قسم المالية', 'name_en' => 'Finance Department'],
            ['name' => 'قسم العلاقات العامة والتوجيه المعنوي', 'name_en' => 'Public Relations and Morale Guidance'],
            ['name' => 'قسم التحقيق بحوادث الطيران', 'name_en' => 'Aviation Accident Investigation'],
            ['name' => 'قسم الامن', 'name_en' => 'Security Department'],
            ['name' => 'شؤون المرضى', 'name_en' => 'Patient Affairs'],
            ['name' => 'السجلات الطبية', 'name_en' => 'Medical Records'],
            ['name' => 'مدير مكتب مدير المركز الطبي', 'name_en' => 'Medical Center Director Office'],
            ['name' => 'المساعد لشؤون الامداد والتموين', 'name_en' => 'Assistant for Supply Affairs'],
            ['name' => 'ادارة التموين', 'name_en' => 'Supply Management'],
            ['name' => 'ادارة المشتريات', 'name_en' => 'Procurement Management'],
            ['name' => 'ادارة الخدمات المساندة', 'name_en' => 'Support Services'],
            ['name' => 'قسم خدمة النظافة', 'name_en' => 'Cleaning Services'],
            ['name' => 'قسم النقل', 'name_en' => 'Transportation Department'],
            ['name' => 'قسم السلامة', 'name_en' => 'Safety Department'],
            ['name' => 'قسم الاتصالات وتقنية المعلومات والحاسب الآلي', 'name_en' => 'IT and Communications'],
            ['name' => 'قسم المتابعة', 'name_en' => 'Follow-up Department'],
            ['name' => 'قسم الشؤون الدينية', 'name_en' => 'Religious Affairs'],
            ['name' => 'مكتب المساعد للشؤون الادارية', 'name_en' => 'Assistant Office for Administrative Affairs'],
            ['name' => 'قسم شؤون الضباط والافراد', 'name_en' => 'Officers and Personnel Affairs'],
            ['name' => 'قسم الموارد البشرية', 'name_en' => 'Human Resources'],
            ['name' => 'قسم الاتصالات الادارية', 'name_en' => 'Administrative Communications'],
            ['name' => 'قسم مكافحة المخدرات', 'name_en' => 'Anti-Narcotics Department'],
            ['name' => 'قسم الشرطة العسكرية', 'name_en' => 'Military Police'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
