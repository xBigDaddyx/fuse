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
        Schema::table('user_company', function (Blueprint $table) {
            $table->string('employee_id')->nullable();
            $table->string('department')->nullable();
            $table->string('job_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_company', function (Blueprint $table) {
            $table->dropColumn('employee_id');
            $table->dropColumn('department');
            $table->dropColumn('job_title');
        });
    }
};
