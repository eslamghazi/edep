<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tickets')->insert([
            [
                'ticket_code' => 'TICKET001',
                'printer_code' => 'PRINTER001',
                'description' => 'Description for Ticket 1',
                'report' => 'Report for Ticket 1',
                'image' => 'ticket1.jpg',
                'status' => 'new',
                'requester_name' => 'John Doe',
                'phone' => '123-456-7890',
                'email' => 'john@example.com',
                'user_id' => null, // User ID if applicable
                'city_id' => 1, // City ID if applicable
                'building_id' => 1, // Building ID if applicable
                'problem_type_id' => 1, // Problem Type ID if applicable
                'printer_id' => 1, // Printer ID if applicable
            ],
            [
                'ticket_code' => 'TICKET002',
                'printer_code' => 'PRINTER002',
                'description' => 'Description for Ticket 2',
                'report' => 'Report for Ticket 2',
                'image' => 'ticket2.jpg',
                'status' => 'inProgress',
                'requester_name' => 'Jane Smith',
                'phone' => '987-654-3210',
                'email' => 'jane@example.com',
                'user_id' => 1, // User ID if applicable
                'city_id' => 1, // City ID if applicable
                'building_id' => 1, // Building ID if applicable
                'problem_type_id' => 1, // Problem Type ID if applicable
                'printer_id' => 1, // Printer ID if applicable
            ],
        ]);
    }
}
