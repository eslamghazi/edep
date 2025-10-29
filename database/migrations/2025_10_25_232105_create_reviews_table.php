<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('professionalism')->unsigned()->nullable()->comment('Rating 0-5');
            $table->tinyInteger('response_time')->unsigned()->nullable()->comment('Rating 0-5');
            $table->tinyInteger('quality_of_work')->unsigned()->nullable()->comment('Rating 0-5');
            $table->tinyInteger('communication')->unsigned()->nullable()->comment('Rating 0-5');
            $table->tinyInteger('overall_satisfaction')->unsigned()->nullable()->comment('Rating 0-5');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
