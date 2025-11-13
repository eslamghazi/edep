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
            $table->string('technician_name')->nullable()->comment('Name of the technician');
            $table->tinyInteger('service_quality')->unsigned()->nullable()->comment('Rating 1-5');
            $table->tinyInteger('response_time')->unsigned()->nullable()->comment('Rating 1-5');
            $table->tinyInteger('technician_behavior')->unsigned()->nullable()->comment('Rating 1-5');
            $table->tinyInteger('technician_competence')->unsigned()->nullable()->comment('Rating 1-5');
            $table->enum('problem_solved', ['full', 'partial', 'no', 'yes_certainly'])->nullable()->comment('Problem resolution status');
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
