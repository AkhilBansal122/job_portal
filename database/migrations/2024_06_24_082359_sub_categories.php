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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subCategory_id');
            $table->string('subCategory_name');
            $table->string('subCategory_slug');
            $table->string('subCategory_image')->nullable();
            $table->double('category_discount', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_kaywords');
            $table->tinyInteger('status')->default(1);
            $table->foreign('subCategory_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');

    }
};
