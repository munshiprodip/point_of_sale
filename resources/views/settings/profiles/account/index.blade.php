@extends('layouts.datatable')
@section('title', 'Account Settings')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
            <li class="nav-item"><a class="nav-link active" href="{{ route('profiles.account') }}"><i class="ti-xs ti ti-users me-1"></i> Account</a></li>
                <li class="nav-item"><a class="nav-link " href="{{ route('profiles.security') }}"><i class="ti-xs ti ti-lock me-1"></i> Security</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="ti-xs ti ti-file-description me-1"></i> App UI</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="ti-xs ti ti-bell me-1"></i> Shortcuts</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="ti-xs ti ti-link me-1"></i> Assistants</a></li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset('avaters').'/'.auth()->user()->avater}}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="avater" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
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
                                <label for="name" class="form-label">Full Name</label>
                                <input class="form-control" type="text" id="name" name="name" value="{{ auth()->user()->name }}" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="text" id="email" name="email" value="{{ auth()->user()->email }}" placeholder="john.doe@example.com" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nid" class="form-label">NID</label>
                                <input type="text" class="form-control" id="nid" name="nid" value="{{ auth()->user()->nid }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phone">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">BD (+88)</span>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ auth()->user()->phone }}" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="present_address" class="form-label">Present Address</label>
                                <input type="text" class="form-control" id="present_address" name="present_address" value="{{ auth()->user()->present_address }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="permanent_address" class="form-label">Permanent Address</label>
                                <input type="text" class="form-control" id="permanent_address" name="permanent_address" value="{{ auth()->user()->permanent_address }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input class="form-control" type="text" id="dob" name="dob" value="{{ auth()->user()->dob }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="reg_no" class="form-label">Registration Number</label>
                                <input type="text" class="form-control" id="reg_no" name="reg_no" value="{{ auth()->user()->reg_no }}"  />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="religion" class="form-label">Religion</label>
                                <input type="text" class="form-control" id="religion" name="religion" value="{{ auth()->user()->religion }}"  />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" class="form-control" id="nationality" name="nationality" value="{{ auth()->user()->nationality }}"  />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="gender">Gender</label>
                                <select id="gender" name="gender" class="select3 form-select">
                                    <option value="">Select</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}" {{ auth()->user()->gender==$gender ? 'selected' : '' }} > {{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="bloodgroup">Blood Group</label>
                                <select id="bloodgroup" name="bloodgroup" class="select3 form-select">
                                    <option value="">Select</option>
                                    @foreach($bloodgroups as $bg)
                                        <option value="{{ $bg }}" {{ auth()->user()->bloodgroup==$bg ? 'selected' : '' }} > {{ $bg }}</option>
                                    @endforeach
                                </select>
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

            

            let e = document.getElementById("uploadedAvatar");
            const l = document.querySelector(".account-file-input"),
            c = document.querySelector(".account-image-reset");
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
                        url: `{{ route('profiles.account.update') }}`,
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