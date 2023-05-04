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
            $table->string('nid')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('dob')->nullable();
            $table->string('reg_no')->nullable();
            $table->string('avater')->nullable();
            $table->string('signature')->nullable();

            $table->integer('gender')->nullable();
            $table->integer('religion')->nullable();

            $table->string('nationality')->nullable();
            $table->integer('bloodgroup')->nullable();

            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nid');
            $table->dropColumn('phone');
            $table->dropColumn('dob');
            $table->dropColumn('reg_no');
            $table->dropColumn('avater');
            $table->dropColumn('signature');
            $table->dropColumn('gender');
            $table->dropColumn('religion');
            $table->dropColumn('nationality');
            $table->dropColumn('bloodgroup');
            $table->dropColumn('present_address');
            $table->dropColumn('permanent_address');
        });
    }
};
