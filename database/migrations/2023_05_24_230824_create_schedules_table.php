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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();

            $table->tinyInteger('saturday')->default(0);
            $table->tinyInteger('sunday')->default(0);
            $table->tinyInteger('monday')->default(0);
            $table->tinyInteger('tuesday')->default(0);
            $table->tinyInteger('wednesday')->default(0);
            $table->tinyInteger('thursday')->default(0);
            $table->tinyInteger('friday')->default(0);

            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('schedules');
    }
};
