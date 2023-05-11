@extends('layouts.datatable')
@section('title', 'EMR Settings')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('settings.profiles.menu')
            <div class="card mb-4">
                <h5 class="card-header">EMR Options</h5>
                <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset('images/logo').'/'.$personal_settings?->org_logo}}" alt="org_logo" class="d-block w-px-100 h-px-100 rounded" id="uploadLogo" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new logo</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="org_logo" class="org_logo-input" hidden accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-label-secondary org_logo-reset mb-3">
                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-md p-4">
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_patient_info_modal == 1? "checked" : "" }} name="prescription_patient_info_modal" id="prescription_patient_info_modal">
                                    <label class="form-check-label" for="prescription_patient_info_modal">Patient's Info</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_vital_sign_modal == 1? "checked" : "" }} name="prescription_vital_sign_modal" id="prescription_vital_sign_modal">
                                    <label class="form-check-label" for="prescription_vital_sign_modal">Vital Sign</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_allergy_modal == 1? "checked" : "" }} name="prescription_allergy_modal" id="prescription_allergy_modal">
                                    <label class="form-check-label" for="prescription_allergy_modal">Allergy</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_past_history_modal == 1? "checked" : "" }} name="prescription_past_history_modal" id="prescription_past_history_modal">
                                    <label class="form-check-label" for="prescription_past_history_modal">Past History</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_gynae_obs_modal == 1? "checked" : "" }} name="prescription_gynae_obs_modal" id="prescription_gynae_obs_modal">
                                    <label class="form-check-label" for="prescription_gynae_obs_modal">Obs/Gynae</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_child_history_modal == 1? "checked" : "" }} name="prescription_child_history_modal" id="prescription_child_history_modal">
                                    <label class="form-check-label" for="prescription_child_history_modal">Child History</label>
                                </div>
                            </div>

                            <div class="col-md p-4">
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_chief_complaint_tab == 1? "checked" : "" }} name="prescription_chief_complaint_tab" id="prescription_chief_complaint_tab">
                                    <label class="form-check-label" for="prescription_chief_complaint_tab">Chief Complaint</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_case_summery_tab == 1? "checked" : "" }} name="prescription_case_summery_tab" id="prescription_case_summery_tab">
                                    <label class="form-check-label" for="prescription_case_summery_tab">Case Summery</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_drug_history_tab == 1? "checked" : "" }} name="prescription_drug_history_tab" id="prescription_drug_history_tab">
                                    <label class="form-check-label" for="prescription_drug_history_tab">Drug History</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_on_examinition_tab == 1? "checked" : "" }} name="prescription_on_examinition_tab" id="prescription_on_examinition_tab">
                                    <label class="form-check-label" for="prescription_on_examinition_tab">On Examination</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_investigation_tab == 1? "checked" : "" }} name="prescription_investigation_tab" id="prescription_investigation_tab">
                                    <label class="form-check-label" for="prescription_investigation_tab">Investigation</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_diagnosis_tab == 1? "checked" : "" }} name="prescription_diagnosis_tab" id="prescription_diagnosis_tab">
                                    <label class="form-check-label" for="prescription_diagnosis_tab">Diagnosis</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->prescription_procedure_tab == 1? "checked" : "" }} name="prescription_procedure_tab" id="prescription_procedure_tab">
                                    <label class="form-check-label" for="prescription_procedure_tab">Procedure</label>
                                </div>
                            </div>

                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                    </div>
                <!-- /Account -->
                </form>
            </div>
            
        </div>
    </div>
@endsection


@section('script')
    <script>

        $(function(){

            

            let e = document.getElementById("uploadLogo");
            const l = document.querySelector(".org_logo-input"),
            c = document.querySelector(".org_logo-reset");
            if (e) {
            const r = e.src;
            (l.onchange = () => {
                l.files[0] && (e.src = window.URL.createObjectURL(l.files[0]));
            }),
                (c.onclick = () => {
                (l.value = ""), (e.src = r);
                });
            }


            let formAccountSettings = $('#formAccountSettings');

            formAccountSettings.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('settings.emr.update') }}`,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire({
                                icon: data.type, // "success", "error", "warning", "info", "question"
                                title: data.title,
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: !1,
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'warning', // "success", "error", "warning", "info", "question"
                                title: "Warning!",
                                text: 'Oops, something went wrong. Please try again.',
                                timer: 1500,
                                showConfirmButton: !1,
                            });
                        }
                    });
                    return false;
                }
            });

        });



















        
    </script>
@endsection