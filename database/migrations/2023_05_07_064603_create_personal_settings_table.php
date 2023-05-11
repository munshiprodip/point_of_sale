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
        Schema::create('personal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('org_title')->nullable();
            $table->string('org_subtitle')->nullable();
            $table->string('org_logo')->nullable();
            $table->string('org_phone')->nullable();
            $table->string('org_fax')->nullable();
            $table->string('org_mail')->nullable();
            $table->string('org_web')->nullable();
            $table->string('org_address')->nullable();

            $table->tinyInteger('prescription_patient_info_modal')->default(1);
            $table->tinyInteger('prescription_vital_sign_modal')->default(1);
            $table->tinyInteger('prescription_allergy_modal')->default(1);
            $table->tinyInteger('prescription_past_history_modal')->default(1);
            $table->tinyInteger('prescription_gynae_obs_modal')->default(1);
            $table->tinyInteger('prescription_child_history_modal')->default(1);
            $table->tinyInteger('prescription_chief_complaint_tab')->default(1);
            $table->tinyInteger('prescription_case_summery_tab')->default(1);
            $table->tinyInteger('prescription_drug_history_tab')->default(1);
            $table->tinyInteger('prescription_on_examinition_tab')->default(1);
            $table->tinyInteger('prescription_investigation_tab')->default(1);
            $table->tinyInteger('prescription_diagnosis_tab')->default(1);
            $table->tinyInteger('prescription_procedure_tab')->default(1);

            $table->tinyInteger('print_margin_top')->default(1);
            $table->tinyInteger('print_margin_bottom')->default(1);
            $table->tinyInteger('print_margin_left')->default(1);
            $table->tinyInteger('print_margin_right')->default(1);
            $table->tinyInteger('print_chief_complaint')->default(1);
            $table->tinyInteger('print_case_summery')->default(1);
            $table->tinyInteger('print_on_examinition')->default(1);
            $table->tinyInteger('print_investigation')->default(1);
            $table->tinyInteger('print_diagnosis')->default(1);
            $table->tinyInteger('print_advice')->default(1);
            $table->tinyInteger('print_follow_up')->default(1);
            $table->tinyInteger('print_signature')->default(1);
            $table->tinyInteger('print_image')->default(1);
            
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
        Schema::dropIfExists('personal_settings');
    }
};
