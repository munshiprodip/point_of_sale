@extends('layouts.datatable')
@section('title', 'EMR Settings')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('settings.profiles.menu')
            <div class="card mb-4">
                <h5 class="card-header">Print Options</h5>
                <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset('images/signatures').'/'.auth()->user()->signature}}" alt="signature" class="d-block w-px-100 h-px-100 rounded" id="uploadSignature" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Upload Signature</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="signature" class="signature-input" hidden accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-label-secondary signature-reset mb-3">
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
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_chief_complaint == 1? "checked" : "" }} name="print_chief_complaint" id="print_chief_complaint">
                                    <label class="form-check-label" for="print_chief_complaint">Chief Complaint</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_case_summery == 1? "checked" : "" }} name="print_case_summery" id="print_case_summery">
                                    <label class="form-check-label" for="print_case_summery">Case Summery</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_on_examinition == 1? "checked" : "" }} name="print_on_examinition" id="print_on_examinition">
                                    <label class="form-check-label" for="print_on_examinition">On Examinition</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_investigation == 1? "checked" : "" }} name="print_investigation" id="print_investigation">
                                    <label class="form-check-label" for="print_investigation">Investigation</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_diagnosis == 1? "checked" : "" }} name="print_diagnosis" id="print_diagnosis">
                                    <label class="form-check-label" for="print_diagnosis">Diagnosis</label>
                                </div>
                            </div>

                            <div class="col-md p-4">
                                
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_advice == 1? "checked" : "" }} name="print_advice" id="print_advice">
                                    <label class="form-check-label" for="print_advice">Advice</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_follow_up == 1? "checked" : "" }} name="print_follow_up" id="print_follow_up">
                                    <label class="form-check-label" for="print_follow_up">Follow Up</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_signature == 1? "checked" : "" }} name="print_signature" id="print_signature">
                                    <label class="form-check-label" for="print_signature">Signature</label>
                                </div>
                                <div class="form-check form-check-primary mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" {{ $personal_settings?->print_image == 1? "checked" : "" }} name="print_image" id="print_image">
                                    <label class="form-check-label" for="print_image">Image</label>
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

            

            let e = document.getElementById("uploadSignature");
            const l = document.querySelector(".signature-input"),
            c = document.querySelector(".signature-reset");
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
                        url: `{{ route('settings.print.update') }}`,
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