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
        Schema::table('employee_users', function (Blueprint $table) {
            $table->integer('other_type')->default(0); // default 0 means not selected other 1 means selected other
            $table->integer('approvalStatus')->default(0); // default 0 means pending 1 means approve, 2 means rejected
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_users', function (Blueprint $table) {
            $table->dropColumn('other_type');
            $table->dropColumn('approvalStatus');
        });
    }
};
