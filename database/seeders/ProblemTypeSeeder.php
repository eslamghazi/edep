<?php

namespace Database\Seeders;

use App\Models\ProblemType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProblemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProblemType::create(['name' => 'توقف الطابعة نهائيا', 'name_en' => 'Printer completely stopped']);
        ProblemType::create(['name' => 'جوده الطباعة سيئة', 'name_en' => 'Poor print quality']);
        ProblemType::create(['name' => 'انحشار الورق', 'name_en' => 'Paper jam']);
        ProblemType::create(['name' => 'عطل وحدة النسخ', 'name_en' => 'Copy unit failure']);
        ProblemType::create(['name' => 'ربط الطابعة مع الشبكه او الحاسوب', 'name_en' => 'Network or computer connection']);
        ProblemType::create(['name' => 'عطل في نظام تشغيل الطابعة', 'name_en' => 'Printer operating system failure']);
        ProblemType::create(['name' => 'ظهور رساله خلل في شاشه الطابعة', 'name_en' => 'Error message on printer screen']);
        ProblemType::create(['name' => 'اخري', 'name_en' => 'Other']);
    }
}
