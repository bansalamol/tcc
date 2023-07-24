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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_code');
            $table->string('clinic');
            $table->string('appointment_type'); // Fix Appointment => Fix Appointment / Tentative Appointment / Prospective lead / Interested Lead / Non interested
            $table->integer('lead_interest_score')->nullable();
            $table->string('health_problem'); // enum value with same value   => map with health problems  table as well appointment id as well 
            $table->string('current_status'); // Visiting / Appointment postponed / Appointment canceled / Visited / Converted
            $table->string('cancellation_reason')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('assigned_to'); // Presales Executive ID who booked the appointment
            $table->unsignedBigInteger('reference_id')->nullable(); // Reference ID of previous appointment entry
            $table->unsignedBigInteger('missed_appointment_executive_id')->nullable(); // Missed appointment executive
            $table->string('active')->nullable();
            $table->string('visited')->nullable();
            $table->dateTime('last_called_datetime')->nullable();
            $table->dateTime('last_messaged_datetime')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // Presales Executive ID who booked the appointment
            $table->unsignedBigInteger('updated_by')->nullable(); // Presales Executive ID who updated the appointment
            $table->timestamps(); // created by & updated 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
