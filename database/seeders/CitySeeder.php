<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dammam = City::create(['name' => 'الدمام']);

        Building::create(['name' => 'مبنى التعليم الرئيسي', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى الخدمات المساندة', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى الشؤون التعليمية', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مكتب التعليم بغرب الدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مكتب التعليم بشرق الدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مكتب التعليم بقطاع شرق الدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مكتب التعليم بقطاع شرق الدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى المستودعات الرئيسية', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى معهد التربية الفكرية', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مركز التدريب التربوي الأول بالدمام (قيادات) بالمحمدية', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مركز التشغيل والصيانة بالدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى إدارة الخدمات العامة', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى بيت الطالب', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مركز التدريب التربوي بشرق الدمام - بالعزيزية', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مركز التشخيص والتدخل المبكر', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مركز التشغيل والصيانة قسم التكييف والتبريد', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مركز التدريب التربوي الثاني بالدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مركز التدريب التربوي بالدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مستودعات الصيانة بالعدامة', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى المعسكر الكشفي', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مستودعات الصناعية بالدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى مركز الطموح والأمل بالدمام', 'city_id' => $dammam->id]);
        Building::create(['name' => 'مبنى معهد الأمل', 'city_id' => $dammam->id]);

        $khobar = City::create(['name' => 'الخبر']);

        Building::create(['name' => 'مبنى مكتب التعليم بالخبر', 'city_id' => $khobar->id]);
        Building::create(['name' => 'مركز هبة لمتلازمة داون', 'city_id' => $khobar->id]);
        Building::create(['name' => 'مبنى مركز التدريب التربوي بالخبر', 'city_id' => $khobar->id]);
        Building::create(['name' => 'مبنى الخدمات المساندة - الخبر', 'city_id' => $khobar->id]);
        Building::create(['name' => 'مركز التشغيل والصيانة بالخبر', 'city_id' => $khobar->id]);
        Building::create(['name' => 'مبنى الحركة - الكراج بالخبر', 'city_id' => $khobar->id]);
        Building::create(['name' => 'مبنى المستودعات الفرعية بالخبر', 'city_id' => $khobar->id]);

        $qatif = City::create(['name' => 'القطيف']);

        Building::create(['name' => 'مبنى مكتب التعليم بالقطيف', 'city_id' => $qatif->id]);
        Building::create(['name' => 'مبنى مكتب التعليم بالقطيف الجديد', 'city_id' => $qatif->id]);
        Building::create(['name' => 'مبنى الصيانة الفرعية بالقطيف', 'city_id' => $qatif->id]);
        Building::create(['name' => 'مبنى الخدمات المساندة بالقطيف', 'city_id' => $qatif->id]);
        Building::create(['name' => 'مبنى المستودعات الفرعية بالقطيف', 'city_id' => $qatif->id]);

        $buqayq = City::create(['name' => 'بقيق']);

        Building::create(['name' => 'مبنى مكتب التعليم بقطاع بقيق', 'city_id' => $buqayq->id]);
        Building::create(['name' => 'مبانى مكتب التعليم بقطاع بقيق', 'city_id' => $buqayq->id]);
        Building::create(['name' => 'مركز التشغيل والصيانة بقيق', 'city_id' => $buqayq->id]);

        $jubail = City::create(['name' => 'الجبيل']);

        Building::create(['name' => 'مبنى مكتب التعليم بالجبيل', 'city_id' => $jubail->id]);
        Building::create(['name' => 'مبنى مركز التدريب التربوي الجبيل', 'city_id' => $jubail->id]);

        $khafji = City::create(['name' => 'الخفجى']);

        Building::create(['name' => 'مبنى مكتب التعليم بقطاع الخفجى', 'city_id' => $khafji->id]);

        $rasTanura = City::create(['name' => 'رأس تنورة']);

        Building::create(['name' => 'مبنى مكتب التعليم برأس تنورة', 'city_id' => $rasTanura->id]);

        $alUla = City::create(['name' => 'قرية العليا']);

        Building::create(['name' => 'مبنى مكتب التعليم بقطاع قرية العليا', 'city_id' => $alUla->id]);

        $dhahran = City::create(['name' => 'الظهران']);

        Building::create(['name' => 'مبنى مكتب التعليم بالظهران', 'city_id' => $dhahran->id]);

        $alNairyah = City::create(['name' => 'قطاع النعيرية']);

        Building::create(['name' => 'مبنى مكتب التعليم بقطاع النعيرية', 'city_id' => $alNairyah->id]);

        $alRafiah = City::create(['name' => 'الرفيعة']);

        Building::create(['name' => 'مبنى فرع الخدمات المساندة بالرفيعة', 'city_id' => $alRafiah->id]);

        $saihat = City::create(['name' => 'سيهات']);

        Building::create(['name' => 'مبنى مركز التدريب التربوي بسيهات', 'city_id' => $saihat->id]);
    }
}
