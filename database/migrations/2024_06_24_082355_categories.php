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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string('category_name');
            $table->string('category_slug');
            $table->string('category_image')->nullable();
            $table->double('category_discount', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->tinyInteger('status')->default(1);
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');

    }
};
