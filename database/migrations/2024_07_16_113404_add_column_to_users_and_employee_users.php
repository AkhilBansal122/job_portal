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
            
            $table->string('token')->nullable();
            $table->string('type')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            
        });
        Schema::table('employee_users', function (Blueprint $table) {
           
            $table->string('token')->nullable();
            $table->string('type')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('token');
            $table->dropColumn('otp_expires_at');
            
        });
        Schema::table('employee_users', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('token');
            $table->dropColumn('otp_expires_at');
        });
    }
};
