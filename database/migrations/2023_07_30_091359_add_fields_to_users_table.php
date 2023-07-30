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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('daily_lead_limit')->default(10);
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->enum('type', ['Incoming calls', 'Incoming leads', 'Old leads', 'Missed appointment'])->nullable();
            $table->text('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('daily_lead_limit');
            $table->dropColumn('manager_id');
            $table->dropColumn('type');
            $table->dropColumn('comment');
        });
    }
};
