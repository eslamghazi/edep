<?php

namespace Database\Seeders;

use App\Models\Printer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Printer names are already in English, so name_en will be the same
        Printer::Create(['name' => 'HP', 'name_en' => 'HP']);
        Printer::Create(['name' => 'Epson', 'name_en' => 'Epson']);
        Printer::Create(['name' => 'Brother', 'name_en' => 'Brother']);
        Printer::Create(['name' => 'Canon', 'name_en' => 'Canon']);
        Printer::Create(['name' => 'Kyocera', 'name_en' => 'Kyocera']);
        Printer::Create(['name' => 'Ricoh', 'name_en' => 'Ricoh']);
        Printer::Create(['name' => 'Samsung', 'name_en' => 'Samsung']);
        Printer::Create(['name' => 'Konica', 'name_en' => 'Konica']);
        Printer::Create(['name' => 'Toshiba', 'name_en' => 'Toshiba']);
    }
}
