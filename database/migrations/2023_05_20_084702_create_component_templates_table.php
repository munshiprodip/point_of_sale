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
        Schema::create('component_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('template_type')->nullable();
            $table->string('description')->nullable();
            $table->longText('template_en')->nullable();
            $table->longText('template_bn')->nullable();

            $table->tinyInteger('active_status')->default(1);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_templates');
    }
};
