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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->unsignedBigInteger('phone_number');
            $table->enum('sex', ['Male', 'Female', 'Other'])->nullable();
            $table->date('birth_date')->nullable();
            $table->tinyInteger('age');
            $table->string('profession')->nullable();
            $table->unsignedBigInteger('alternate_phone_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('do_not_contact')->default('No');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
