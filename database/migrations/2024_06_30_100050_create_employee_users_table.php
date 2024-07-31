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
        Schema::create('employee_users', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->string('profile')->nullable();
            $table->string('govt_id')->nullable(); // Combined field for Aadhar card, PAN no
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->date('joining_date')->nullable();
            $table->boolean('account_verify_status')->nullable();
            $table->boolean('verify_otp_status')->nullable();
            $table->integer('otp')->nullable();
            $table->string('token')->nullable();
            $table->string('type')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->integer('other_type')->default(0); // default 0 means not selected other 1 means selected other
            $table->integer('approvalStatus')->default(0); // here 0 means pending 1 means approved and 2 means rejected 
            $table->tinyInteger('status')->default(0);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_users');
    }
};
