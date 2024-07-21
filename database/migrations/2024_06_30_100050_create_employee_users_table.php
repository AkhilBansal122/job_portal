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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->string('profile')->nullable();
            $table->decimal('amount_earned', 10, 2)->default(0);
            $table->decimal('rating', 2, 1)->default(0);
            $table->decimal('hourly_rate', 10, 2)->default(0);
            $table->unsignedBigInteger('job_id')->nullable();
            $table->integer('total_job_done_count')->default(0);
            $table->string('govt_id')->nullable(); // Combined field for Aadhar card, PAN no
            $table->unsignedBigInteger('job_category_id')->nullable(); // Dropdown job list
            $table->decimal('location_latitude', 10, 7)->nullable();
            $table->decimal('location_longitude', 10, 7)->nullable();
            $table->string('bank_account')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('bank_name')->nullable();
            $table->text('bank_address')->nullable();
            $table->date('joining_date')->nullable();
            $table->boolean('verify_otp_status')->nullable();
            $table->integer('otp')->nullable(); 
            $table->string('status')->default('active');
            $table->foreign('job_category_id')->references('id')->on('job_categories')->onDelete('set null');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('set null');
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
