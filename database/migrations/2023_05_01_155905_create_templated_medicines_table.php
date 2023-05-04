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
        Schema::create('templated_medicines', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medicine_template_id')->nullable();
            $table->foreign('medicine_template_id')->references('id')->on('medicine_templates')->onDelete('cascade');

            $table->string('medicine')->nullable();
            $table->string('dose')->nullable();
            $table->string('instruction')->nullable();
            $table->string('duration')->nullable();
            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templated_medicines');
    }
};
