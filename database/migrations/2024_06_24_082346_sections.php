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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_name');
            $table->string('section_slug');
            $table->string('section_image')->nullable();
            $table->double('section_discount')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_kaywords');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
