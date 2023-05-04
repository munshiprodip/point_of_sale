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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

            $table->string('anaemia')->nullable();
            $table->string('jaundice')->nullable();
            $table->string('cyanosis')->nullable();
            $table->string('oedema')->nullable();
            $table->string('dehydration')->nullable();

            $table->string('pulse_rate')->nullable();
            $table->string('respiratory_rate')->nullable();
            $table->string('bp_systolic')->nullable();
            $table->string('bp_diastolic')->nullable();
            $table->string('temperature')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('bmi')->nullable();
            $table->string('rr')->nullable();
            $table->string('ofc')->nullable();
            $table->string('bsa')->nullable();
            $table->string('us_ratio')->nullable();
            $table->string('ls_ratio')->nullable();
            $table->string('other_oe')->nullable();

            $table->longText('chief_complaints')->nullable();
            $table->longText('case_summary')->nullable();
            $table->longText('past_medical_history')->nullable();
            $table->longText('past_surgical_history')->nullable();
            $table->longText('past_personal_history')->nullable();
            $table->longText('past_family_history')->nullable();
            $table->longText('past_drug_history')->nullable();
            $table->longText('allergy_history')->nullable();

            $table->longText('food_allergy')->nullable();
            $table->longText('drug_allergy')->nullable();
            $table->longText('other_allergy')->nullable();

            $table->longText('cardiovascular_system')->nullable();
            $table->longText('respiratory_system')->nullable();
            $table->longText('abdominal_system')->nullable();
            $table->longText('genito_urinary_system')->nullable();
            $table->longText('locomotor_system')->nullable();
            $table->longText('nervous_system')->nullable();
            $table->longText('others_system')->nullable();

            $table->longText('investigations')->nullable();
            $table->longText('diagnosis')->nullable();
            $table->longText('procedure')->nullable();

            $table->longText('advice')->nullable();
            $table->string('follow_up')->nullable();
            $table->string('next_visit')->nullable();

            $table->string('image')->nullable();
           
            $table->tinyInteger('status')->default(0);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
