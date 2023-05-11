@extends('layouts.datatable')
@section('title', 'Organization Settings')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('settings.profiles.menu')
            <div class="card mb-4">
                <h5 class="card-header">Organization Information</h5>
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
                            <div class="mb-3 col-md-6">
                                <label for="org_title" class="form-label">Organization Title</label>
                                <input class="form-control" type="text" id="org_title" name="org_title" value="{{ $personal_settings?->org_title }}" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="org_subtitle" class="form-label">Organization Subtitle</label>
                                <input class="form-control" type="text" id="org_subtitle" name="org_subtitle" value="{{ $personal_settings?->org_subtitle }}" placeholder="john.doe@example.com" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="org_phone">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">BD (+88)</span>
                                    <input type="text" id="org_phone" name="org_phone" class="form-control" value="{{ $personal_settings?->org_phone }}" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="org_fax">Fax</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">BD (+88)</span>
                                    <input type="text" id="org_fax" name="org_fax" class="form-control" value="{{ $personal_settings?->org_fax }}" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="org_mail" class="form-label">Email</label>
                                <input type="text" class="form-control" id="org_mail" name="org_mail" value="{{ $personal_settings?->org_mail }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="org_web" class="form-label">Web</label>
                                <input type="text" class="form-control" id="org_web" name="org_web" value="{{ $personal_settings?->org_web }}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="org_address" class="form-label">Organization Address</label>
                                <input class="form-control" type="text" id="org_address" name="org_address" value="{{ $personal_settings?->org_address }}" />
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
                        url: `{{ route('settings.organization.update') }}`,
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