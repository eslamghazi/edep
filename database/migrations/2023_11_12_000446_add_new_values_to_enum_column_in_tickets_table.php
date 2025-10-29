<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Modify the column to include new enum values
        DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM('new', 'inProgress', 'closed', 'waiting', 'close_request') DEFAULT 'new'");

    }

    /**
     * Reverse the migrations.
     */
       public function down()
    {
        // Revert the column to its original state if needed
        DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM('new', 'inProgress', 'closed')");
    }

};
