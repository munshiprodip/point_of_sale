@extends('layouts.datatable')
@section('title', 'Create Appointment')

@section('content')
<form id="create_appointment_form" autocomplete=off method="POST">
  <div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="phone">Phone *</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="phone" class="form-control" name="phone"
                                    placeholder="phone" />
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="dob">Date of Birth</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="dob" name="dob" class="form-control pickr"
                                    placeholder="YYYY-MM-DD" />
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="name">Patient's Name *</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="name" class="form-control" name="name"
                                    placeholder="Patient's Name" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="age">Age</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id="age_years" class="form-control" name="age_years"
                                    placeholder="Year" />
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id="age_months" class="form-control" name="age_months"
                                    placeholder="Month" />
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id="age_days" class="form-control" name="age_days"
                                    placeholder="Day" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="father_name">Father's Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="father_name" class="form-control"
                                    name="father_name" placeholder="Father's Name" />
                            </div>
                        </div>
                    </div>




                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="marital_status">Marital status</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="demo-inline-spacing ">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="marital_status"
                                            id="radio_marital_status_Married" value="Married" />
                                        <label class="form-check-label"
                                            for="radio_marital_status_Married">Married</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="marital_status"
                                            id="radio_marital_status_Unmarried" value="Unmarried" />
                                        <label class="form-check-label"
                                            for="radio_marital_status_Unmarried">Unmarried</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="mother_name">Mother's Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="mother_name" class="form-control"
                                    name="mother_name" placeholder="Mother's Name" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="spouse_name">Spouse Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="spouse_name" class="form-control"
                                    name="spouse_name" placeholder="Spouse Name" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="gender_id">Gender</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="demo-inline-spacing ">
                                    @foreach ($genders as $gender)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender"
                                                id="radio_gender_{{ $gender }}"
                                                value="{{ $gender}}" />
                                            <label class="form-check-label"
                                                for="radio_gender_{{ $gender}}">{{ $gender}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="religion">Religion</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="select2 form-select" id="religion" name="religion">
                                    @foreach ($religions as $religion)
                                        <option value="{{ $religion }}">{{ $religion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="nationality">Nationality</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="select2 form-select" id="nationality" name="nationality">
                                    <option value="Bangladeshi">Bangladeshi</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="nid">NID</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="nid" class="form-control" name="nid"
                                    placeholder="NID" />
                            </div>
                        </div>
                    </div>
                    







                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="email">Email</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" id="email" class="form-control" name="email"
                                    placeholder="Email" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="occupation">Occupation</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="occupation" class="form-control" name="occupation"
                                    placeholder="Occupation" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="bloodgroup">Blood group</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="select2 form-select" id="bloodgroup"
                                    name="bloodgroup">
                                    @foreach ($bloodgroups as $bloodgroup)
                                        <option value="{{ $bloodgroup }}">{{ $bloodgroup }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="present_address">Present Address</label>
                            </div>
                            <div class="col-sm-9">
                              <textarea class="form-control" name="present_address" id="present_address" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-1 row">
                            <div class="col-sm-3">
                                <label class="col-form-label" for="permanent_address">Permanent Address</label>
                            </div>
                            <div class="col-sm-9">
                              <textarea class="form-control" name="permanent_address" id="permanent_address" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label" for="temperature">Temperature</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="temperature" class="form-control"
                                            name="temperature" placeholder="Temperature" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label" for="pulse_rate">Pulse rate</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="pulse_rate" class="form-control"
                                            name="pulse_rate" placeholder="Pulse rate" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label" for="respiratory_rate">Respiratory
                                            rate</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="respiratory_rate" class="form-control"
                                            name="respiratory_rate" placeholder="Respiratory rate" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label" for="blood_pressure">Blood
                                            pressure</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="bp_systolic" class="form-control"
                                            name="bp_systolic" placeholder="Systolic" />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="bp_diastolic" class="form-control"
                                            name="bp_diastolic" placeholder="Diastolic" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label" for="height">Height</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="height" class="form-control" name="height"
                                            placeholder="inch" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label" for="weight">Weight</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="weight" class="form-control" name="weight"
                                            placeholder="kg" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label" for="sao2">O2 Saturation</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="sao2" class="form-control"
                                            name="sao2" placeholder="Oxygen Saturation" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label" for="ofc">OFC</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="ofc" class="form-control" name="ofc"
                                            placeholder="OFC" />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" name="patient_id" id="patient_id">
                            <button type="submit" class="btn btn-primary me-1">Appointment & Prescribe</button>
                            <button type="reset" class="btn btn-outline-secondary">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>













@endsection


@section('script')
    <script>
        
        let create_appointment_form = $('#create_appointment_form');
        create_appointment_form.on('submit', function(e) {
            let formData = new FormData(this);
            if (!e.isDefaultPrevented()) {
                $.ajax({
                    url: `{{ route('appointments.store') }}`,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if(data.success){
                            window.location.href = `{{ route('appointments.prescribe', ':appointment_no') }}`.replace(':appointment_no', data.appointment_no);
                        }else{
                            Swal.fire({
                                icon: data.type, // "success", "error", "warning", "info", "question"
                                title: data.title,
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: !1,
                            });
                        } 
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
    </script>
@endsection