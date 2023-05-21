@extends('layouts.datatable')
@section('title', 'Prescribe')

@section('style')
  <style>
    .media-overlay {
      position: absolute;
      top: 100%;
      width: calc(100% - 26px);
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      border: 1px solid #ddd;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      transition: all 0.3s ease-in-out;
    }

    .gallery-item:hover>.media-overlay {
      top: 0;
    }

  </style>
@endsection

@section('content')
  <!-- Appointment's Information -->
  <div class="card mb-3">
    <div class="row mx-3 my-2 text-uppercase">
      <div class="col-3 col-md-3">
        Reg No : {{ $appointment->patient->registration_no }}
      </div>
      <div class="col-3 col-md-3">
        Name : {{ $appointment->patient->name }}
      </div>
      <div class="col-3 col-md-3">
        Age : {{ $ageText['years'].'Y '.$ageText['months'].'M '.$ageText['days'].'D' }}
      </div>
      <div class="col-3 col-md-3">
        Gender : {{ $appointment->patient->gender }}
      </div>
    </div>
  </div>
  <!-- End Appointment's Information -->


  <div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
      <!-- Pages buttons -->
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#chief_complaints_and_others_tab" aria-controls="chief_complaints_and_others_tab" aria-selected="true">PAGE 1</button>
      </li>
      <li class="nav-item" role="presentation">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#medication_and_others_tab" aria-controls="medication_and_others_tab" aria-selected="false" tabindex="-1">PAGE 2</button>
      </li>
      <!-- End Pages buttons -->

      <!-- Modal's buttons -->
      <li style="margin-left: auto;" >
        @if($personal_settings->prescription_patient_info_modal)
        <button type="button" class="btn btn-outline-warning waves-effect ms-1" data-bs-toggle="modal" data-bs-target="#patients_info_modal">Patient's Info</button>
        @endif
        @if($personal_settings->prescription_vital_sign_modal)
        <button type="button" class="btn btn-outline-warning waves-effect ms-1" data-bs-toggle="modal" data-bs-target="#vital_sign_modal">Vital Sign</button>
        @endif
        @if($personal_settings->prescription_allergy_modal)
        <button type="button" class="btn btn-outline-warning waves-effect ms-1" data-bs-toggle="modal" data-bs-target="#allergy_modal">Allergy</button>
        @endif
        @if($personal_settings->prescription_past_history_modal)
        <button type="button" class="btn btn-outline-warning waves-effect ms-1" data-bs-toggle="modal" data-bs-target="#past_history_modal">Past History</button>
        @endif
        @if($personal_settings->prescription_gynae_obs_modal)
        <button type="button" class="btn btn-outline-warning waves-effect ms-1" data-bs-toggle="modal" data-bs-target="#gynae_obs_modal">Gynae & Obs</button>
        @endif
        @if($personal_settings->prescription_child_history_modal)
        <button type="button" class="btn btn-outline-warning waves-effect ms-1" data-bs-toggle="modal" data-bs-target="#child_history_modal">Child History</button>
        @endif
        <a target="_blank" href="{{ route('appointments.prescription', $appointment->id ) }}" type="button" class="btn btn-outline-secondary waves-effect ms-1">
          <span class="ti-xs ti ti-printer me-1"></span>Print
        </a>
      </li>
      <!-- End Modal's buttons -->
    </ul>

    <!-- All Modals -->

    <!-- Patients Info Modal -->
    @if($personal_settings->prescription_patient_info_modal)
    <div class="modal fade" id="patients_info_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <form class="modal-content" id="form_patients_info" >
          @method('PATCH')
          <div class="modal-header">
            <h5 class="modal-title">Patient's Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <div class="nav-align-top">
              <ul class="nav nav-tabs justify-content-end" role="tablist">
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#patients_personal_info_tab" aria-controls="patients_personal_info_tab" aria-selected="false" tabindex="-1">Personal Info</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#patients_others_info_tab" aria-controls="patients_others_info_tab" aria-selected="false" tabindex="-1">Others Info</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#patients_address_tab" aria-controls="patients_address_tab" aria-selected="true">Address</button>
                </li>
              </ul>

              <div class="tab-content px-0">
                <!-- Start tab -->
                <div class="tab-pane fade active show" id="patients_personal_info_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="nid">NID</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="nid" class="form-control" name="nid" placeholder="NID" value="{{ $appointment->patient->nid }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="phone">Phone</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="phone" class="form-control" name="phone" placeholder="phone" value="{{ $appointment->patient->phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="name">Patient's Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" id="name" class="form-control" name="name" placeholder="Patient's Name" value="{{ $appointment->patient->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="father_name">Father's Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" id="father_name" class="form-control" name="father_name" placeholder="Father's Name" value="{{ $appointment->patient->father_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="mother_name">Mother's Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" id="mother_name" class="form-control" name="mother_name" placeholder="Mother's Name" value="{{ $appointment->patient->mother_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="dob">Date of Birth</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" id="dob" name="dob" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" value="{{ $appointment->patient->dob }}">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="patients_others_info_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="occupation">Occupation</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="occupation" class="form-control" name="occupation" placeholder="Occupation" value="{{ $appointment->patient->occupation }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="bloodgroup">Blood group</label>
                            </div>
                            <div class="col-sm-8">
                                <select class="select2 form-select" id="bloodgroup" name="bloodgroup">
                                    <option value="">Select</option>
                                    @foreach ($bloodgroups as $row)
                                        <option value="{{ $row }}" {{ $appointment->patient->bloodgroup == $row ? 'selected' : '' }}>
                                            {{ $row }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="marital_status">Marital status</label>
                            </div>
                            <div class="col-sm-8">
                              <select class="select2 form-select" id="marital_status" name="marital_status">
                                <option value="">Select </option>
                                @foreach ($marital_status as $row)
                                    <option value="{{ $row }}" {{ $appointment->patient->marital_status == $row ? 'selected' : '' }}>
                                        {{ $row }}
                                    </option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="religion">Religion</label>
                            </div>
                            <div class="col-sm-8">
                                <select class="select2 form-select" id="religion" name="religion">
                                  <option value="">Select </option>
                                  @foreach ($religions as $row)
                                      <option value="{{ $row }}" {{ $appointment->patient->religion == $row ? 'selected' : '' }}>
                                          {{ $row }}
                                      </option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="spouse_name">Spouse Name</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" id="spouse_name" class="form-control" name="spouse_name" placeholder="Spouse Name" value="{{ $appointment->patient->spouse_name }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="gender">Gender</label>
                            </div>
                            <div class="col-sm-10">
                              <select class="select2 form-select" id="gender" name="gender">
                                <option value="">Select </option>
                                @foreach ($genders as $row)
                                    <option value="{{ $row }}" {{ $appointment->patient->gender == $row ? 'selected' : '' }}>
                                        {{ $row }}
                                    </option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="nationality">Nationality</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" id="nationality" class="form-control" name="nationality" placeholder="Nationality" value="{{ $appointment->patient->nationality }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-4">
                                <label class="col-form-label" for="email">Email</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email" value="{{ $appointment->patient->email }}" />
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="patients_address_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-12 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="present_address">Present Address</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" id="present_address" class="form-control" name="present_address" placeholder="Present Address" value="{{ $appointment->patient->present_address }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="mb-1 row">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="permanent_address">Permanent Address</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" id="permanent_address" class="form-control" name="permanent_address" placeholder="Permanent Address" value="{{ $appointment->patient->permanent_address }}" />
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
              </div>
            </div>           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
    @endif
    <!-- End Patients Info Modal -->

    <!-- Vital sign Modal -->
    @if($personal_settings->prescription_vital_sign_modal)
    <div class="modal fade" id="vital_sign_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <form class="modal-content" id="form_vital_sign" onsubmit="saveAppointmentData();" >
          @method('PATCH')
          <div class="modal-header">
            <h5 class="modal-title">Vital Sign</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <div class="row">
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="pulse_rate">Pulse rate</label>
                      </div>
                      <div class="col-sm-8">
                          <input type="text" id="pulse_rate" class="form-control" name="pulse_rate" placeholder="Pulse rate" value="{{ $appointment->pulse_rate }}">
                      </div>
                  </div>
              </div>
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="respiratory_rate">Respiratory rate</label>
                      </div>
                      <div class="col-sm-8">
                          <input type="text" id="respiratory_rate" class="form-control" name="respiratory_rate" placeholder="Respiratory rate" value="{{ $appointment->respiratory_rate }}">
                      </div>
                  </div>
              </div>
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="blood_pressure">Blood pressure</label>
                      </div>
                      <div class="col-sm-4">
                          <input type="text" id="blood_pressure_sys" class="form-control" name="bp_systolic" placeholder="Systolic" value="{{ $appointment->bp_systolic }}">
                      </div>
                      <div class="col-sm-4">
                          <input type="text" id="blood_pressure_dis" class="form-control" name="bp_diastolic" placeholder="Diastolic" value="{{ $appointment->bp_diastolic }}">
                      </div>
                  </div>
              </div>
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="height">Height</label>
                      </div>
                      <div class="col-sm-8">
                          <input type="text" id="height" class="form-control" name="height" placeholder="centimeter" value="{{ $appointment->height }}">
                      </div>
                  </div>
              </div>
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="weight">Weight</label>
                      </div>
                      <div class="col-sm-8">
                          <input type="text" id="weight" class="form-control" name="weight" placeholder="kg" value="{{ $appointment->weight }}">
                      </div>
                  </div>
              </div>
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="sao2">O2 Saturation</label>
                      </div>
                      <div class="col-sm-8">
                          <input type="text" id="sao2" class="form-control" name="sao2" placeholder="Oxygen Saturation" value="{{ $appointment->sao2 }}">
                      </div>
                  </div>
              </div>
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="ofc">OFC</label>
                      </div>
                      <div class="col-sm-8">
                          <input type="text" id="ofc" class="form-control" name="ofc" placeholder="OFC" value="{{ $appointment->ofc }}">
                      </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
    @endif
    <!-- End Vital sign Modal -->

    <!-- Allergy Modal -->
    @if($personal_settings->prescription_allergy_modal)
    <div class="modal fade" id="allergy_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <form class="modal-content" id="form_allergy" onsubmit="saveAppointmentData();" >
          @method('PATCH')
          <div class="modal-header">
            <h5 class="modal-title">Allergy</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <div class="row">
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="food_allergy">Food Allergy</label>
                      </div>
                      <div class="col-sm-8">
                        <textarea class="form-control" name="food_allergy" id="food_allergy" rows="4">{{ $appointment->food_allergy }}</textarea>
                      </div>
                  </div>
              </div>
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="drug_allergy">Drug Allergy</label>
                      </div>
                      <div class="col-sm-8">
                        <textarea class="form-control" name="drug_allergy" id="drug_allergy" rows="4">{{ $appointment->drug_allergy }}</textarea>
                      </div>
                  </div>
              </div>
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                          <label class="col-form-label" for="other_allergy">Other's Allergy</label>
                      </div>
                      <div class="col-sm-8">
                        <textarea class="form-control" name="other_allergy" id="other_allergy" rows="4">{{ $appointment->other_allergy }}</textarea>
                      </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
    @endif
    <!-- End Allergy Modal -->

    <!-- Past History Modal -->
    @if($personal_settings->prescription_past_history_modal)
    <div class="modal fade" id="past_history_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <form class="modal-content" id="form_past_history" onsubmit="saveAppointmentData();">
          @method('PATCH')
          <div class="modal-header">
            <h5 class="modal-title">Patient's History</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <div class="nav-align-top">
              <ul class="nav nav-tabs justify-content-end" role="tablist">
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#past_medical_history_tab" aria-controls="past_medical_history_tab" aria-selected="false" tabindex="-1">Past Medical History</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#past_surgical_history_tab" aria-controls="past_surgical_history_tab" aria-selected="false" tabindex="-1">Past Surgical History</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#past_family_history_tab" aria-controls="past_family_history_tab" aria-selected="true">Past Family History</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#past_personal_history_tab" aria-controls="past_personal_history_tab" aria-selected="true">Past Personal History</button>
                </li>
              </ul>

              <div class="tab-content px-0">
                <!-- Start tab -->
                <div class="tab-pane fade active show" id="past_medical_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="mb-1">
                      <textarea class="form-control" name="past_medical_history" rows="10" spellcheck="false">{{ $appointment->past_medical_history }}</textarea>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="past_surgical_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="mb-1">
                      <textarea class="form-control" name="past_surgical_history" rows="10" spellcheck="false">{{ $appointment->past_surgical_history }}</textarea>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="past_family_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="mb-1">
                      <textarea class="form-control" name="past_family_history" rows="10" spellcheck="false">{{ $appointment->past_family_history }}</textarea>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="past_personal_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="mb-1">
                      <textarea class="form-control" name="past_personal_history" rows="10" spellcheck="false">{{ $appointment->past_personal_history }}</textarea>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
              </div>
            </div>           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
    @endif
    <!-- End Past History Modal -->

    <!-- Gynae & Obs Modal -->
    @if($personal_settings->prescription_gynae_obs_modal)
    <div class="modal fade" id="gynae_obs_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <form class="modal-content" id="form_gynae_obs" onsubmit="saveAppointmentData();">
          @method('PATCH')
          <div class="modal-header">
            <h5 class="modal-title">Gynae & Obs</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <div class="nav-align-top">
              <ul class="nav nav-tabs justify-content-end" role="tablist">
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#para_tab" aria-controls="para_tab" aria-selected="false" tabindex="-1">Para</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#obs_history_tab" aria-controls="obs_history_tab" aria-selected="false" tabindex="-1">Obs History</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#sexual_history_tab" aria-controls="sexual_history_tab" aria-selected="true">Sexual History</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#menstrual_history_tab" aria-controls="menstrual_history_tab" aria-selected="true">Menstrual History</button>
                </li>
              </ul>

              <div class="tab-content px-0">
                <!-- Start tab -->
                <div class="tab-pane fade active show" id="para_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                      <div class=" row">
                          <div class="col-sm-4">
                              <label class="col-form-label" for="obs_history_option_1">G</label>
                          </div>
                          <div class="col-sm-8">
                              <input type="text" id="obs_history_option_1" class="form-control" name="obs_history_option_1" placeholder="G" value="{{ $appointment->obs_history_option_1 }}">
                          </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                          <div class="col-sm-4">
                              <label class="col-form-label" for="obs_history_option_2">T</label>
                          </div>
                          <div class="col-sm-8">
                              <input type="text" id="obs_history_option_2" class="form-control" name="obs_history_option_2" placeholder="T" value="{{ $appointment->obs_history_option_2 }}">
                          </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                          <div class="col-sm-4">
                              <label class="col-form-label" for="obs_history_option_3">P</label>
                          </div>
                          <div class="col-sm-8">
                              <input type="text" id="obs_history_option_3" class="form-control" name="obs_history_option_3" placeholder="P" value="{{ $appointment->obs_history_option_3 }}">
                          </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                          <div class="col-sm-4">
                              <label class="col-form-label" for="obs_history_option_4">A</label>
                          </div>
                          <div class="col-sm-8">
                              <input type="text" id="obs_history_option_4" class="form-control" name="obs_history_option_4" placeholder="A" value="{{ $appointment->obs_history_option_4 }}">
                          </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                          <div class="col-sm-4">
                              <label class="col-form-label" for="obs_history_option_5">L</label>
                          </div>
                          <div class="col-sm-8">
                              <input type="text" id="obs_history_option_5" class="form-control" name="obs_history_option_5" placeholder="L" value="{{ $appointment->obs_history_option_5 }}">
                          </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                          <div class="col-sm-4">
                              <label class="col-form-label" for="obs_history_option_6">Parity</label>
                          </div>
                          <div class="col-sm-8">
                              <input type="text" id="obs_history_option_6" class="form-control" name="obs_history_option_6" placeholder="Parity" value="{{ $appointment->obs_history_option_6 }}">
                          </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                          <div class="col-sm-4">
                              <label class="col-form-label" for="obs_history_option_7">Age Last Child</label>
                          </div>
                          <div class="col-sm-8">
                              <input type="text" id="obs_history_option_7" class="form-control" name="obs_history_option_7" placeholder="Age Last Child" value="{{ $appointment->obs_history_option_7 }}">
                          </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                          <div class="col-sm-4">
                              <label class="col-form-label" for="obs_history_option_8">Type of delevery</label>
                          </div>
                          <div class="col-sm-8">
                              <select class="form-control" name="obs_history_option_8" id="obs_history_option_8">
                                <option value="">Select one</option>
                                <option value="Normal" {{ $appointment->obs_history_option_8 == 'Normal' ? 'selected' : ''}} >Normal</option>
                                <option value="C/S" {{ $appointment->obs_history_option_8 == 'C/S' ? 'selected' : ''}} >C/S</option>
                                <option value="Instrumental" {{ $appointment->obs_history_option_8 == 'Instrumental' ? 'selected' : ''}}>Instrumental</option>
                              </select>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="obs_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_9">Amenorrhea</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_9" id="obs_history_option_9">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->obs_history_option_9 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->obs_history_option_9 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_10">Fetal Movement</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_10" id="obs_history_option_10">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->obs_history_option_10 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->obs_history_option_10 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_11">Engagement</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_11" id="obs_history_option_11">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->obs_history_option_11 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->obs_history_option_11 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_12">Presentation</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_12" id="obs_history_option_12">
                            <option value="">Select one</option>
                            <option value="Floating" {{ $appointment->obs_history_option_12 == "Floating" ? "selected" : "" }} >Floating</option>
                            <option value="Breech" {{ $appointment->obs_history_option_12 == "Breech" ? "selected" : "" }} >Breech</option>
                            <option value="Cephalic" {{ $appointment->obs_history_option_12 == "Cephalic" ? "selected" : "" }} >Cephalic</option>
                            <option value="Oblique" {{ $appointment->obs_history_option_12 == "Oblique" ? "selected" : "" }} >Oblique</option>
                            <option value="Transverse" {{ $appointment->obs_history_option_12 == "Transverse" ? "selected" : "" }} >Transverse</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_13">Fetal Heart</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_13" id="obs_history_option_13">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->obs_history_option_13 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->obs_history_option_13 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="sexual_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_14">Contraceptive</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_14" id="obs_history_option_14">
                            <option value="">Select one</option>
                            <option value="Condom" {{ $appointment->obs_history_option_14 == "Condom" ? "selected" : "" }} >Condom</option>
                            <option value="Female condom" {{ $appointment->obs_history_option_14 == "Female condom" ? "selected" : "" }} >Female condom</option>
                            <option value="Birth control pill" {{ $appointment->obs_history_option_14 == "Birth control pill" ? "selected" : "" }} >Birth control pill</option>
                            <option value="IUD" {{ $appointment->obs_history_option_14 == "IUD" ? "selected" : "" }} >IUD</option>
                            <option value="Injection" {{ $appointment->obs_history_option_14 == "Injection" ? "selected" : "" }} >Injection</option>
                            <option value="Norplant" {{ $appointment->obs_history_option_14 == "Norplant" ? "selected" : "" }} >Norplant</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_15">Dyspareunia</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_15" id="obs_history_option_15">
                          <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->obs_history_option_15 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->obs_history_option_15 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_16">Frequency</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="obs_history_option_16" id="obs_history_option_16" value="{{ $appointment->obs_history_option_16 }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_17">Post coital bleeding</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_17" id="obs_history_option_17">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->obs_history_option_17 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->obs_history_option_17 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="menstrual_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_18">Cycle</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_18" id="obs_history_option_18">
                            <option value="">Select one</option>
                            <option value="Scanty" {{ $appointment->obs_history_option_18 == "Scanty" ? "selected" : "" }}>Scanty</option>
                            <option value="Normal" {{ $appointment->obs_history_option_18 == "Normal" ? "selected" : "" }}>Normal</option>
                            <option value="Heavy" {{ $appointment->obs_history_option_18 == "Heavy" ? "selected" : "" }}>Heavy</option>
                            <option value="Too heavy" {{ $appointment->obs_history_option_18 == "Too heavy" ? "selected" : "" }}>Too heavy</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_19">Amount of flow</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="obs_history_option_19" id="obs_history_option_19">
                            <option value="">Select one</option>
                            <option value="Mild" {{ $appointment->obs_history_option_19 == "Mild" ? "selected" : "" }}>Mild</option>
                            <option value="Moderate" {{ $appointment->obs_history_option_19 == "Moderate" ? "selected" : "" }}>Moderate</option>
                            <option value="Severe" {{ $appointment->obs_history_option_19 == "Severe" ? "selected" : "" }}>Severe</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_20">Menopause</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="obs_history_option_20" id="obs_history_option_20" value="{{ $appointment->obs_history_option_20 }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_21">Period</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="obs_history_option_21" id="obs_history_option_21" value="{{ $appointment->obs_history_option_21 }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_22">LMP</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="obs_history_option_22" id="obs_history_option_22" value="{{ $appointment->obs_history_option_22 }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_23">Menarche</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="obs_history_option_23" id="obs_history_option_23" value="{{ $appointment->obs_history_option_23 }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="obs_history_option_24">EDD</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="obs_history_option_24" id="obs_history_option_24" value="{{ $appointment->obs_history_option_24 }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
              </div>
            </div>           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
    @endif
    <!-- End Gynae & Obs Modal -->

    <!-- Child history Modal -->
    @if($personal_settings->prescription_child_history_modal)
    <div class="modal fade" id="child_history_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <form class="modal-content" id="form_child_history" onsubmit="saveAppointmentData();">
          @method('PATCH')
          <div class="modal-header">
            <h5 class="modal-title">Child History</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <div class="nav-align-top">
              <ul class="nav nav-tabs justify-content-end" role="tablist">
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#birth_history_tab" aria-controls="birth_history_tab" aria-selected="false" tabindex="-1">Birth History</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#health_history_tab" aria-controls="health_history_tab" aria-selected="false" tabindex="-1">Health History</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#developmental_milestones_tab" aria-controls="developmental_milestones_tab" aria-selected="true">Developmental Milestones</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#feeding_history_tab" aria-controls="feeding_history_tab" aria-selected="true">Feeding History</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button type="button" class="nav-link " role="tab" data-bs-toggle="tab" data-bs-target="#temperament_personality_tab" aria-controls="temperament_personality_tab" aria-selected="true">Temperament & Personality</button>
                </li>
              </ul>

              <div class="tab-content px-0">
                <!-- Start tab -->
                <div class="tab-pane fade active show" id="birth_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_1">Mother's Blood Group</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_1" id="child_history_option_1">
                            <option value="">Select one</option>
                            @foreach($bloodgroups as $row)
                            <option value="{{$row}}" {{ $appointment->child_history_option_1 == $row? "selected":"" }} >{{$row}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_2">Consanguinity of marrige</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_2" id="child_history_option_2">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_2 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_2 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_3">Rhesus incompatibility</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_3" id="child_history_option_3">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_3 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_3 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_4">Haemolytic disease</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_4" id="child_history_option_4">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_4 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_4 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_5">Mothers age during birth</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="child_history_option_5" id="child_history_option_5" value="{{$appointment->child_history_option_5}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_6">Gestation</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="child_history_option_6" id="child_history_option_6" value="{{$appointment->child_history_option_6}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_7">Type of delevery</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_7" id="child_history_option_7">
                            <option value="">Select one</option>
                            <option value="Normal" {{ $appointment->child_history_option_7 == 'Normal' ? 'selected' : ''}} >Normal</option>
                            <option value="C/S" {{ $appointment->child_history_option_7 == 'C/S' ? 'selected' : ''}} >C/S</option>
                            <option value="Instrumental" {{ $appointment->child_history_option_7 == 'Instrumental' ? 'selected' : ''}}>Instrumental</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_8">Duration of labour</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_8" id="child_history_option_8">
                            <option value="">Select one</option>
                            <option value="Prolonged" {{ $appointment->child_history_option_8 == 'Prolonged' ? 'selected' : ''}}>Prolonged</option>
                            <option value="Short" {{ $appointment->child_history_option_8 == 'Short' ? 'selected' : ''}}>Short</option>
                            <option value="Normal" {{ $appointment->child_history_option_8 == 'Normal' ? 'selected' : ''}}>Normal</option>
                            <option value="Induced" {{ $appointment->child_history_option_8 == 'Induced' ? 'selected' : ''}}>Induced</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_9">Complications during pregnancy</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_9" id="child_history_option_9">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_9 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_9 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_10">Birth trauma</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_10" id="child_history_option_10">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_10 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_10 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_11">Resuscitation</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_11" id="child_history_option_11">
                            <option value="">Select one</option>
                            <option value="Required" {{ $appointment->child_history_option_11 == "Required" ? "selected" : "" }}>Required</option>
                            <option value="Not required" {{ $appointment->child_history_option_11 == "Not required" ? "selected" : "" }}>Not required</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_12">Miscarriages</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_12" id="child_history_option_12">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_12 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_12 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_13">Fetal distress</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_13" id="child_history_option_13">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_13 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_13 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_14">Presentation</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_14" id="child_history_option_14">
                            <option value="">Select one</option>
                            <option value="Floating" {{ $appointment->child_history_option_14 == "Floating" ? "selected" : "" }}>Floating</option>
                            <option value="Breech" {{ $appointment->child_history_option_14 == "Breech" ? "selected" : "" }}>Breech</option>
                            <option value="Cephalic" {{ $appointment->child_history_option_14 == "Cephalic" ? "selected" : "" }}>Cephalic</option>
                            <option value="Oblique" {{ $appointment->child_history_option_14 == "Oblique" ? "selected" : "" }}>Oblique</option>
                            <option value="Transverse" {{ $appointment->child_history_option_14 == "Transverse" ? "selected" : "" }}>Transverse</option>
                            
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_15">Birth weight</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="child_history_option_15" id="child_history_option_15" value="{{ $appointment->child_history_option_15 }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_16">Delayed crying</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_16" id="child_history_option_16">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_16 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_16 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_17">Convulsion seizure</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_17" id="child_history_option_17">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_17 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_17 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_18">Febrile illness</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_18" id="child_history_option_18">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_18 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_18 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_19">Bleeding disorders</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_19" id="child_history_option_19">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_19 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_19 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_20">Jaundice</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_20" id="child_history_option_20">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_20 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_20 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_21">Septicemia</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_21" id="child_history_option_21">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_21 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_21 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_22">Hypoglycemia</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_22" id="child_history_option_22">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_22 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_22 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_23">Respiratory distress</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_23" id="child_history_option_23">
                            <option value="">Select one</option>
                            <option value="Present" {{ $appointment->child_history_option_23 == "Present" ? "selected" : "" }}>Present</option>
                            <option value="Absent" {{ $appointment->child_history_option_23 == "Absent" ? "selected" : "" }}>Absent</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="health_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_24">What is the current health status of your child?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_24" id="child_history_option_24">
                            <option value="">Select one</option>
                            <option value="Excellent" {{ $appointment->child_history_option_24 == "Excellent" ? "selected" : "" }}>Excellent</option>
                            <option value="Good" {{ $appointment->child_history_option_24 == "Good" ? "selected" : "" }}>Good</option>
                            <option value="Fair" {{ $appointment->child_history_option_24 == "Fair" ? "selected" : "" }}>Fair</option>
                            <option value="Poor" {{ $appointment->child_history_option_24 == "Poor" ? "selected" : "" }}>Poor</option>
                            <option value="I don't know" {{ $appointment->child_history_option_24 == "I don't know" ? "selected" : "" }}>I don't know</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_25">Do you have any specific medical concerns about your child?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_25" id="child_history_option_25">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_25 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_25 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_26">Is your child allergic to any medication?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_26" id="child_history_option_26">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_26 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_26 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_27">Medicine list</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="child_history_option_27" id="child_history_option_27" value="{{ $appointment->child_history_option_27 }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_28">Are your child's immunizations up to date?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_28" id="child_history_option_28">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_28 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_28 == "No" ? "selected" : "" }}>No</option>
                            <option value="I don't know" {{ $appointment->child_history_option_28 == "I don't know" ? "selected" : "" }}>I don't know</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_29">Did/does your child had a Hearing screening?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_29" id="child_history_option_29">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_29 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_29 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_30">Did/does your child had a Vision screening?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_30" id="child_history_option_30">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_30 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_30 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_31">Did/does your child had a Speech screening?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_31" id="child_history_option_31">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_31 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_31 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_32">Did/does your child have Recurrent ear infections?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_32" id="child_history_option_32">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_32 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_32 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-4">
                          <label class="col-form-label" for="child_history_option_33">Did/does your child have tubes in his/her ears?</label>
                        </div>
                        <div class="col-sm-8">
                          <select class="form-control" name="child_history_option_33" id="child_history_option_33">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_33 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_33 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="developmental_milestones_tab" role="tabpanel">
                  <div class="row">
                  <strong>If you can recall, record the age at which your child reached the following developmental milestone</strong>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_34">Rolled over</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_34" id="child_history_option_34" value="{{$appointment->child_history_option_34}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_35">Sat up</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_35" id="child_history_option_35" value="{{$appointment->child_history_option_35}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_36">Crawled</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_36" id="child_history_option_36" value="{{$appointment->child_history_option_36}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_37">Walked</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_37" id="child_history_option_37" value="{{$appointment->child_history_option_37}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_38">Spoke first word</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_38" id="child_history_option_38" value="{{$appointment->child_history_option_38}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_39">Talked (2 words)</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_39" id="child_history_option_39" value="{{$appointment->child_history_option_39}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_40">Weaned (Bottle/Breast)</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_40" id="child_history_option_40" value="{{$appointment->child_history_option_40}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_41">Fed self (spoon)</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_41" id="child_history_option_41" value="{{$appointment->child_history_option_41}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_42">Drank from a cup</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_42" id="child_history_option_42" value="{{$appointment->child_history_option_42}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_43">Toilet trained</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_43" id="child_history_option_43" value="{{$appointment->child_history_option_43}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_44">Was your infant</label>
                        </div>
                        <div class="col-sm-6">
                          <select class="form-control" name="child_history_option_44" id="child_history_option_44">
                            <option value="">Select one</option>
                            <option value="Calm" {{ $appointment->child_history_option_44 == 'Calm' ? 'selected' : ''}} >Calm</option>
                            <option value="Colicky" {{ $appointment->child_history_option_44 == 'Colicky' ? 'selected' : ''}} >Colicky</option>
                            <option value="Fussy" {{ $appointment->child_history_option_44 == 'Fussy' ? 'selected' : ''}} >Fussy</option>
                            <option value="Easily comfort" {{ $appointment->child_history_option_44 == 'Easily comfort' ? 'selected' : ''}} >Easily comfort</option>
                            <option value="Excessively irritable" {{ $appointment->child_history_option_44 == 'Excessively irritable' ? 'selected' : ''}} >Excessively irritable</option>
                            <option value="Pleasant/happy" {{ $appointment->child_history_option_44 == 'Pleasant/happy' ? 'selected' : ''}} >Pleasant/happy</option>
                            
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-4 mb-2">
                      <div class=" row">
                        <div class="col-sm-6 ">
                          <label class="col-form-label" for="child_history_option_45">Completed</label>
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="child_history_option_45" id="child_history_option_45" value="{{$appointment->child_history_option_45}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-12 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_46">Is your child currently seeing any medical specialists or therapists (such as a nurologist, occupational therapist, opthalmologist, physical therapist etc)?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_46" id="child_history_option_46">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_46 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_46 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_47">Does your child experience any of the following difficulties with sleep?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_47" id="child_history_option_47">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_47 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_47 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_48">Does your child have any of the following difficults with eating?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_48" id="child_history_option_48">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_48 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_48 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_49">Does your child have any of the following difficults with elimination?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_49" id="child_history_option_49">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_49 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_49 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_50">Does your child use a bottle?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_50" id="child_history_option_50">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_50 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_50 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_51">What hand does your child use to complete task?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_51" id="child_history_option_51">
                            <option value="">Select one</option>
                            <option value="Left" {{ $appointment->child_history_option_51 == "Left" ? "selected" : "" }}>Left</option>
                            <option value="Right" {{ $appointment->child_history_option_51 == "Right" ? "selected" : "" }}>Right</option>
                            <option value="Both" {{ $appointment->child_history_option_51 == "Both" ? "selected" : "" }}>Both</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_52">Does your child have problems with coordination?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_52" id="child_history_option_52">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_52 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_52 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_53">Does your child displayed any unusual repetitive movements or noises?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_53" id="child_history_option_53">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_53 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_53 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_54">Do you have concerns about your child's development in any of this area?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_54" id="child_history_option_54">
                            <option value="">Select one</option>
                            <option value="Speech or Language" {{ $appointment->child_history_option_54 == "Speech or Language" ? "selected" : "" }}>Speech or Language</option>
                            <option value="Motor Skills" {{ $appointment->child_history_option_54 == "Motor Skills" ? "selected" : "" }}>Motor Skills</option>
                            <option value="Social Skills" {{ $appointment->child_history_option_54 == "Social Skills" ? "selected" : "" }}>Social Skills</option>
                            <option value="Cognitive" {{ $appointment->child_history_option_54 == "Cognitive" ? "selected" : "" }}>Cognitive</option>
                            <option value="Sensory" {{ $appointment->child_history_option_54 == "Sensory" ? "selected" : "" }}>Sensory</option>
                            <option value="Behavioral" {{ $appointment->child_history_option_54 == "Behavioral" ? "selected" : "" }}>Behavioral</option>
                            <option value="Emotional" {{ $appointment->child_history_option_54 == "Emotional" ? "selected" : "" }}>Emotional</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_55">Does your child get dressed by themselves?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_55" id="child_history_option_55">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_55 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_55 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_56">Does your child avoid any physical activites?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_56" id="child_history_option_56">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_56 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_56 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_57">Do you have any current concerns regarding your child's speech or language?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_57" id="child_history_option_57">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_57 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_57 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_58">Does your child have a history of speech or language problems?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_58" id="child_history_option_58">
                            <option value="">Select one</option>
                             <option value="Yes" {{ $appointment->child_history_option_58 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_58 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_59">Does your child have any problems with expressive language?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_59" id="child_history_option_59">
                            <option value="">Select one</option>
                             <option value="Yes" {{ $appointment->child_history_option_59 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_59 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_60">Does your child have any problems saying sounds correctly?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_60" id="child_history_option_60">
                            <option value="">Select one</option>
                             <option value="Yes" {{ $appointment->child_history_option_60 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_60 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_61">Does your child have any difficulty with speech fluency?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_61" id="child_history_option_61">
                            <option value="">Select one</option>
                             <option value="Yes" {{ $appointment->child_history_option_61 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_61 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_62">Do you have any specific concerns about your child's hearing/listening?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_62" id="child_history_option_62">
                            <option value="">Select one</option>
                             <option value="Yes" {{ $appointment->child_history_option_62 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_62 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_63">Does your child have any difficulty using or understanding non-verbal cues?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_63" id="child_history_option_63">
                            <option value="">Select one</option>
                            <option value="Body Language" {{ $appointment->child_history_option_63 == "Body Language" ? "selected" : "" }}>Body Language</option>
                            <option value="Facial expressions" {{ $appointment->child_history_option_63 == "Facial expressions" ? "selected" : "" }}>Facial expressions</option>
                            <option value="Tone of voice" {{ $appointment->child_history_option_63 == "Tone of voice" ? "selected" : "" }}>Tone of voice</option>
                            <option value="Rate of speech" {{ $appointment->child_history_option_63 == "Rate of speech" ? "selected" : "" }}>Rate of speech</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_64">Does your child usually play?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_64" id="child_history_option_64">
                            <option value="">Select one</option>
                            <option value="Alone" {{ $appointment->child_history_option_64 == "Alone" ? "selected" : "" }}>Alone</option>
                            <option value="W/Siblings" {{ $appointment->child_history_option_64 == "W/Siblings" ? "selected" : "" }}>W/Siblings</option>
                            <option value="W/Peers" {{ $appointment->child_history_option_64 == "W/Peers" ? "selected" : "" }}>W/Peers</option>
                            <option value="W/Younger Children" {{ $appointment->child_history_option_64 == "W/Younger Children" ? "selected" : "" }}>W/Younger Children</option>
                            <option value="W/Older Children" {{ $appointment->child_history_option_64 == "W/Older Children" ? "selected" : "" }}>W/Older Children</option>
                            <option value="W/Adults" {{ $appointment->child_history_option_64 == "W/Adults" ? "selected" : "" }}>W/Adults</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_65">Does your child have a hard time making friends?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_65" id="child_history_option_65">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_65 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_65 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_66">Is your child currently enrolled in school?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_66" id="child_history_option_66">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_66 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_66 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_67">Do you have concerns regarding school performance?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_67" id="child_history_option_67">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_67 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_67 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_68">Did preschool teachers, daycare providers or other caregivers observe difficulty with any of the following?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_68" id="child_history_option_68">
                            <option value="">Select one</option>
                            <option value="Structured activity" {{ $appointment->child_history_option_68 == "Structured activity" ? "selected" : "" }}>Structured activity</option>
                            <option value="Group activity" {{ $appointment->child_history_option_68 == "Group activity" ? "selected" : "" }}>Group activity</option>
                            <option value="behavior" {{ $appointment->child_history_option_68 == "behavior" ? "selected" : "" }}>behavior</option>
                            <option value="Attention" {{ $appointment->child_history_option_68 == "Attention" ? "selected" : "" }}>Attention</option>
                            <option value="Peer Relationships" {{ $appointment->child_history_option_68 == "Peer Relationships" ? "selected" : "" }}>Peer Relationships</option>
                            <option value="Transitions" {{ $appointment->child_history_option_68 == "Transitions" ? "selected" : "" }}>Transitions</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_69">Do you have concerns related to</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_69" id="child_history_option_69">
                            <option value="">Select one</option>
                            <option value="Off task behavior" {{ $appointment->child_history_option_69 == "Off task behavior" ? "selected" : "" }}>Off task behavior</option>
                            <option value="Attention" {{ $appointment->child_history_option_69 == "Attention" ? "selected" : "" }}>Attention</option>
                            <option value="Concentration" {{ $appointment->child_history_option_69 == "Concentration" ? "selected" : "" }}>Concentration</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="feeding_history_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_70">Colostrum</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_70" id="child_history_option_70">
                            <option value="">Select one</option>
                            <option value="Taken" {{ $appointment->child_history_option_70 == "Taken" ? "selected" : "" }}>Taken</option>
                            <option value="Not taken" {{ $appointment->child_history_option_70 == "Not taken" ? "selected" : "" }}>Not taken</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_71">EBF</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_71" id="child_history_option_71">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_71 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_71 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_72">Bottle feeding</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_72" id="child_history_option_72">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_72 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_72 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_73">Complementary feed</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_73" id="child_history_option_73">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_73 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_73 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_74">Mixed feeding</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_74" id="child_history_option_74">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_74 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_74 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
                <!-- Start tab -->
                <div class="tab-pane fade" id="temperament_personality_tab" role="tabpanel">
                  <div class="row">
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_75">Does your child have frequent temper outbursts (e.g., yelling, hitting or stomping feet)?</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_75" id="child_history_option_75">
                            <option value="">Select one</option>
                            <option value="Yes" {{ $appointment->child_history_option_75 == "Yes" ? "selected" : "" }}>Yes</option>
                            <option value="No" {{ $appointment->child_history_option_75 == "No" ? "selected" : "" }}>No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_76">Energy</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_76" id="child_history_option_76">
                            <option value="">Select one</option>
                            <option value="Sedentary" {{ $appointment->child_history_option_76 == "Sedentary" ? "selected" : "" }}>Sedentary</option>
                            <option value="Active" {{ $appointment->child_history_option_76 == "Active" ? "selected" : "" }}>Active</option>
                            <option value="Very active" {{ $appointment->child_history_option_76 == "Very active" ? "selected" : "" }}>Very active</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_77">First Reaction (to new people, activities, ideas)</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_77" id="child_history_option_77">
                            <option value="">Select one</option>
                            <option value="Avoidant" {{ $appointment->child_history_option_77 == "Avoidant" ? "selected" : "" }}>Avoidant</option>
                            <option value="Shy" {{ $appointment->child_history_option_77 == "Shy" ? "selected" : "" }}>Shy</option>
                            <option value="Outgoing" {{ $appointment->child_history_option_77 == "Outgoing" ? "selected" : "" }}>Outgoing</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_78">Intensity (strength of emotional reactions)</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_78" id="child_history_option_78">
                            <option value="">Select one</option>
                            <option value="Withdraw" {{ $appointment->child_history_option_78 == "Withdraw" ? "selected" : "" }}>Withdraw</option>
                            <option value="Toilet refusal" {{ $appointment->child_history_option_78 == "Toilet refusal" ? "selected" : "" }}>Toilet refusal</option>
                            <option value="Strong reaction" {{ $appointment->child_history_option_78 == "Strong reaction" ? "selected" : "" }}>Strong reaction</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_79">Mood (general emotional tone)</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_79" id="child_history_option_79">
                            <option value="">Select one</option>
                            <option value="Difficult sitting at table" {{ $appointment->child_history_option_79 == "Difficult sitting at table" ? "selected" : "" }}>Difficult sitting at table</option>
                            <option value="Over eats" {{ $appointment->child_history_option_79 == "Over eats" ? "selected" : "" }}>Over eats</option>
                            <option value="Avoids food due to texture" {{ $appointment->child_history_option_79 == "Avoids food due to texture" ? "selected" : "" }}>Avoids food due to texture</option>
                            <option value="Poor food choices" {{ $appointment->child_history_option_79 == "Poor food choices" ? "selected" : "" }}>Poor food choices</option>
                            <option value="Picky eater" {{ $appointment->child_history_option_79 == "Picky eater" ? "selected" : "" }}>Picky eater</option>
                            <option value="Odd eating behaviors" {{ $appointment->child_history_option_79 == "Odd eating behaviors" ? "selected" : "" }}>Odd eating behaviors</option>
                            <option value="Restricted diets" {{ $appointment->child_history_option_79 == "Restricted diets" ? "selected" : "" }}>Restricted diets</option>
                            <option value="Yes" {{ $appointment->child_history_option_79 == "Yes" ? "selected" : "" }}>Yes</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_80">Persistence (ease of stopping when involved in an activity)</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_80" id="child_history_option_80">
                            <option value="">Select one</option>
                            <option value="Hard" {{ $appointment->child_history_option_80 == "Hard" ? "selected" : "" }}>Hard</option>
                            <option value="Easily redirected" {{ $appointment->child_history_option_80 == "Easily redirected" ? "selected" : "" }}>Easily redirected</option>
                            <option value="Hard to focus on an activity" {{ $appointment->child_history_option_80 == "Hard to focus on an activity" ? "selected" : "" }}>Hard to focus on an activity</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_81">Sensitivity (to noises, emotions, tastes, textures, stress)</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_81" id="child_history_option_81">
                            <option value="">Select one</option>
                            <option value="Not sensitive" {{ $appointment->child_history_option_81 == "Not sensitive" ? "selected" : "" }}>Not sensitive</option>
                            <option value="Mild" {{ $appointment->child_history_option_81 == "Mild" ? "selected" : "" }}>Mild</option>
                            <option value="Very sensitive" {{ $appointment->child_history_option_81 == "Very sensitive" ? "selected" : "" }}>Very sensitive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_82">Perceptiveness (notices people, noises, objects)</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_82" id="child_history_option_82">
                            <option value="">Select one</option>
                            <option value="Hardly ever notices" {{ $appointment->child_history_option_82 == "Hardly ever notices" ? "selected" : "" }}>Hardly ever notices</option>
                            <option value="Turns to looks" {{ $appointment->child_history_option_82 == "Turns to looks" ? "selected" : "" }}>Turns to looks</option>
                            <option value="Overly perceptive" {{ $appointment->child_history_option_82 == "Overly perceptive" ? "selected" : "" }}>Overly perceptive</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_83">Adaptability (copes with transitions, changes in routine)</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_83" id="child_history_option_83">
                            <option value="">Select one</option>
                            <option value="Slow" {{ $appointment->child_history_option_83 == "Slow" ? "selected" : "" }}>Slow</option>
                            <option value="Flexible" {{ $appointment->child_history_option_83 == "Flexible" ? "selected" : "" }}>Flexible</option>
                            <option value="Quickly" {{ $appointment->child_history_option_83 == "Quickly" ? "selected" : "" }}>Quickly</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_84">Attention Span/Distractibility</label>
                        </div>
                        <div class="col-sm-4">
                          <select class="form-control" name="child_history_option_84" id="child_history_option_84">
                            <option value="">Select one</option>
                            <option value="Easily distracted" {{ $appointment->child_history_option_84 == "Easily distracted" ? "selected" : "" }}>Easily distracted</option>
                            <option value="Sometimes distracted" {{ $appointment->child_history_option_84 == "Sometimes distracted" ? "selected" : "" }}>Sometimes distracted</option>
                            <option value="Stay focused" {{ $appointment->child_history_option_84 == "Stay focused" ? "selected" : "" }}>Stay focused</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-2">
                      <div class=" row">
                        <div class="col-sm-8 ">
                          <label class="col-form-label" for="child_history_option_85">Additional Comments</label>
                        </div>
                        <div class="col-sm-4">
                          <input class="form-control" name="child_history_option_85" id="child_history_option_85" value="{{ $appointment->child_history_option_85}}">
                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End tab -->
              </div>
            </div>           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
    @endif
    <!-- End Child history Modal -->



    <!-- Favourite clinical components Modal -->
    <div class="modal fade" id="favourite_components_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="favourite_components_modal_title">Favourite</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <table class="dt-responsive table" id="favourite_components_table" >
              <thead>
                  <tr>
                      <th>SL</th>
                      <th>NAME</th>
                      <th>OPTIONS</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End favourite clinical components Modal -->

    <!-- Templated components Modal -->
    <div class="modal fade" id="components_templates_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="components_templates_modal_title">Favourite</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <table class="dt-responsive table" id="components_templates_table" >
              <thead>
                  <tr>
                      <th>SL</th>
                      <th>NAME</th>
                      <th>OPTIONS</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Templated components Modal -->

    <!-- Previous clinical component Modal -->
    <div class="modal fade" id="previous_clinical_components_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="previous_clinical_components_modal_title">Previous</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <table class="dt-responsive table" id="previous_clinical_components_table" >
              <thead>
                <tr>
                  <th>APPOINTMENT</th>
                  <th>NAME</th>
                  <th>OPTIONS</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Previous clinical component Modal -->

    <!-- Media Library Modal -->
    <div class="modal fade" id="media_library_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title mr-3" id="mediaLibraryModalTitle">Image Gallery </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="row" id="media_library_content"></div>
          </div>
          <div class="modal-footer">
              <form method="POST" enctype="multipart/form-data" id="new_media_form">
                  <label for="new_media" class="btn btn-outline-primary ml-3">Upload</label>
                  <input type="file" name="new_media" id="new_media" style="display: none;">
              </form>
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Media Library Modal -->

    <!-- Medicine template form Modal -->
    <div class="modal fade" id="medicine_template_form_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <form class="modal-content" id="medicine_template_form" method="POST">
          <div class="modal-header">
            <h5 class="modal-title">Save as Template</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <div class="row">
              <div class="col-12 mb-2">
                  <div class="mb-1 row">
                      <div class="col-sm-4">
                        <label class="col-form-label">Template Name</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" >
                        <input type="hidden" class="form-control" name="appointment_id" value="{{ $appointment->id }}" >
                      </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
    <!-- End Medicine template form Modal -->

    <!-- Templated medicine Modal -->
    <div class="modal fade" id="templated_medicine_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="templated_medicine_modal_title">Previous</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <table class="dt-responsive table" id="templated_medicine_table" >
              <thead>
                <tr>
                  <th>NAME</th>
                  <th>OPTIONS</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Templated medicine Modal -->

    <!-- Favourite medicine Modal -->
    <div class="modal fade" id="favourite_medicine_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="favourite_medicine_modal_title">Previous</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <table class="dt-responsive table" id="favourite_medicine_table" >
              <thead>
                <tr>
                  <th>MEDICINE</th>
                  <th>DOSE</th>
                  <th>INSTRUCTION</th>
                  <th>DURATION</th>
                  <th>NOTE</th>
                  <th>OPTIONS</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Favourite medicine Modal -->

    <!-- Previous medication Modal -->
    <div class="modal fade" id="previous_medication_modal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="previous_medication_modal_title">Previous</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <table class="dt-responsive table" id="previous_medication_table" >
              <thead>
                <tr>
                  <th>MEDICINE</th>
                  <th>DOSE</th>
                  <th>INSTRUCTION</th>
                  <th>DURATION</th>
                  <th>NOTE</th>
                  <th>OPTIONS</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Previous medication Modal -->

    <!--End All Modals -->


    <!-- Pages tab content -->
    <div class="tab-content py-0 rounded">
      <!-- Page 1 tab -->
      <div class="tab-pane fade active show" id="chief_complaints_and_others_tab" role="tabpanel">
        <div class="bs-stepper vertical vertical-stepper-of-clinical-components">
          <!-- Page 1 steppers -->
          <div class="bs-stepper-header">
            @if($personal_settings->prescription_chief_complaint_tab)
              <div class="step active" data-target="#chief_complaint_step">
                <button type="button" class="step-trigger" aria-selected="false">
                  <span class="bs-stepper-circle">
                    <i class="ti ti-file-description"></i>
                  </span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Chief Complaint</span>
                    <span class="bs-stepper-subtitle">Add Chief Complaint</span>
                  </span>
                </button>
              </div>
              <div class="line"></div>
            @endif
            @if($personal_settings->prescription_case_summery_tab)
              <div class="step" data-target="#case_summary_step">
                <button type="button" class="step-trigger" aria-selected="false">
                  <span class="bs-stepper-circle">
                    <i class="ti ti-user"></i>
                  </span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Case Summery</span>
                    <span class="bs-stepper-subtitle">Add Case Summery</span>
                  </span>
                </button>
              </div>
              <div class="line"></div>
            @endif
            @if($personal_settings->prescription_drug_history_tab)
              <div class="step" data-target="#drug_history_step">
                <button type="button" class="step-trigger" aria-selected="true">
                  <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i>
                  </span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Drug History</span>
                    <span class="bs-stepper-subtitle">Add Drug History</span>
                  </span>
                </button>
              </div>
              <div class="line"></div>
            @endif
            @if($personal_settings->prescription_on_examinition_tab)
              <div class="step" data-target="#on_examination_step">
                <button type="button" class="step-trigger" aria-selected="true">
                  <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i>
                  </span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">On Examination</span>
                    <span class="bs-stepper-subtitle">Add On Examination</span>
                  </span>
                </button>
              </div>
              <div class="line"></div>
            @endif
            @if($personal_settings->prescription_investigation_tab)
              <div class="step" data-target="#investigations_step">
                <button type="button" class="step-trigger" aria-selected="true">
                  <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i>
                  </span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Investigation</span>
                    <span class="bs-stepper-subtitle">Add Investigation</span>
                  </span>
                </button>
              </div>
              <div class="line"></div>
            @endif
            @if($personal_settings->prescription_diagnosis_tab)
              <div class="step" data-target="#diagnosis_step">
                <button type="button" class="step-trigger" aria-selected="true">
                  <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i>
                  </span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Diagnosis</span>
                    <span class="bs-stepper-subtitle">Add Diagnosis</span>
                  </span>
                </button>
              </div>
              <div class="line"></div>
            @endif
            @if($personal_settings->prescription_procedure_tab)
              <div class="step" data-target="#procedure_step">
                <button type="button" class="step-trigger" aria-selected="true">
                  <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i>
                  </span>
                  <span class="bs-stepper-label">
                    <span class="bs-stepper-title">Procedure / Plan</span>
                    <span class="bs-stepper-subtitle">Add Procedure / Plan</span>
                  </span>
                </button>
              </div>
            @endif
          </div>
          <!-- End Page 1 steppers -->

          <!-- Page 1 steps -->
          <div class="bs-stepper-content">
            <form onsubmit="saveAppointmentData();">
              <!-- Chief Complaint -->
              @if($personal_settings->prescription_chief_complaint_tab)
              <div id="chief_complaint_step" class="content active dstepper-block">
                <div class="content-header mb-3 d-flex justify-content-between">
                  <h6 class="mb-0">Chief Complaint</h6>
                  <div>
                    <button class="btn btn-outline-danger btn-xs ms-2" onclick="openFavouriteComponentsModal('chief_complaints'); return false;">
                      <i class="ti ti-heart"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openTemplatedComponentsModal('chief_complaints'); return false;">
                      <i class="ti ti-file-certificate"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openPreviousClinicalComponentsModal('chief_complaints'); return false;">
                      <i class="ti ti-arrow-back-up"></i>
                    </button>
                  </div>
                </div>

                <div class="row g-3">
                  <!-- Forms Inputs -->
                  <div class="col-md-12">
                    <select name="chief_complaints-component_select" class="form-control component_select2">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <textarea class="form-control" name="chief_complaints" id="chief_complaints" rows="14" spellcheck="false">{{ $appointment->chief_complaints }}</textarea>
                  </div>
                  <!-- End Forms Inputs -->

                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev waves-effect">
                        <i class="ti ti-arrow-left me-sm-1"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <div>
                      <button class="btn btn-primary btn-next waves-effect waves-light">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
              @endif
              <!-- Case Summery -->
              @if($personal_settings->prescription_case_summery_tab)
              <div id="case_summary_step" class="content dstepper-block">
                <div class="content-header mb-3 d-flex justify-content-between">
                  <h6 class="mb-0">Case Summery</h6>
                  <div>
                    <button class="btn btn-outline-danger btn-xs ms-2" onclick="openFavouriteComponentsModal('case_summary'); return false;">
                      <i class="ti ti-heart"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openTemplatedComponentsModal('case_summary'); return false;">
                      <i class="ti ti-file-certificate"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openPreviousClinicalComponentsModal('case_summary'); return false;">
                      <i class="ti ti-arrow-back-up"></i>
                    </button>
                  </div>
                </div>

                <div class="row g-3">
                  <!-- Forms Inputs -->
                  <div class="col-md-12">
                    <select name="case_summary-component_select" class="form-control component_select2">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <textarea class="form-control" name="case_summary" id="case_summary" rows="14" spellcheck="false">{{ $appointment->case_summary }}</textarea>
                  </div>
                  <!-- End Forms Inputs -->

                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev waves-effect">
                        <i class="ti ti-arrow-left me-sm-1"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <div>
                      <button class="btn btn-primary btn-next waves-effect waves-light">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
              @endif
              <!-- Drug History -->
              @if($personal_settings->prescription_drug_history_tab)
              <div id="drug_history_step" class="content dstepper-block">
                <div class="content-header mb-3 d-flex justify-content-between">
                  <h6 class="mb-0">Drug History</h6>
                  <div>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openTemplatedComponentsModal('past_drug_history'); return false;">
                      <i class="ti ti-file-certificate"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openPreviousClinicalComponentsModal('past_drug_history'); return false;">
                      <i class="ti ti-arrow-back-up"></i>
                    </button>
                  </div>
                </div>

                <div class="row g-3">
                  <!-- Forms Inputs -->
                  <div class="col-md-12">
                    <textarea class="form-control" name="past_drug_history" id="past_drug_history" rows="14" spellcheck="false">{{ $appointment->past_drug_history }}</textarea>
                  </div>
                  <!-- End Forms Inputs -->

                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev waves-effect">
                        <i class="ti ti-arrow-left me-sm-1"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <div>
                      <button class="btn btn-primary btn-next waves-effect waves-light">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
              @endif
              <!-- On Examination -->
              @if($personal_settings->prescription_on_examinition_tab)
              <div id="on_examination_step" class="content dstepper-block">
                <div class="row g-3">
                  <div class="nav-align-top">
                    <ul class="nav nav-tabs justify-content-end" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#general_physical_examination_tab" aria-controls="general_physical_examination_tab" aria-selected="false" tabindex="-1">General Physical Examination</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#systemic_examination_tab" aria-controls="systemic_examination_tab" aria-selected="false" tabindex="-1">Systemic Examination</button>
                      </li>
                    </ul>

                    <div class="tab-content px-0">
                      <!-- Start tab -->
                      <div class="tab-pane fade active show" id="general_physical_examination_tab" role="tabpanel">
                        <div class="row mb-2">

                          <div id="cp_anemia" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Anaemia</label>
                                  <div class="col-xl-8">
                                      <select class="form-select" name="anaemia">
                                        <option>Select one</option>
                                        @foreach($examination_values as $row)
                                        <option value="{{ $row }}" {{ $appointment->anaemia == $row? 'selected' : '' }} >{{ $row }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>

                          <div id="cp_jaundice" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Jaundice</label>
                                  <div class="col-xl-8">
                                      <select class="form-select" name="jaundice">
                                        <option>Select one</option>
                                        @foreach($examination_values as $row)
                                        <option value="{{ $row }}" {{ $appointment->jaundice == $row? 'selected' : '' }} >{{ $row }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>



                          <div id="cp_cyanosis" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Cyanosis</label>
                                  <div class="col-xl-8">
                                      <select class="form-select" name="cyanosis">
                                        <option>Select one</option>
                                        @foreach($examination_values as $row)
                                        <option value="{{ $row }}" {{ $appointment->cyanosis == $row? 'selected' : '' }} >{{ $row }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>

                          <div id="cp_odema" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Oedema</label>
                                  <div class="col-xl-8">
                                      <select class="form-select" name="oedema">
                                        <option>Select one</option>
                                        @foreach($examination_values as $row)
                                        <option value="{{ $row }}" {{ $appointment->oedema == $row? 'selected' : '' }} >{{ $row }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>

                          <div id="cp_dehydration" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Dehydration</label>
                                  <div class="col-xl-8">
                                      <select class="form-select" name="dehydration">
                                        <option>Select one</option>
                                        @foreach($examination_values as $row)
                                        <option value="{{ $row }}" {{ $appointment->dehydration == $row? 'selected' : '' }} >{{ $row }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>


                          <div id="cp_pulse_rate" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Pulse</label>
                                  <div class="col-xl-8">
                                      <input type="number" class="form-control" placeholder="pulse/min" name="pulse_rate" value="{{ $appointment->pulse_rate }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_bp" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">BP</label>
                                  <div class="col-xl-4">
                                      <input type="number" class="form-control" placeholder="bp_systolic" name="bp_systolic" value="{{ $appointment->bp_systolic }}">
                                  </div>
                                  <div class="col-sm-4">
                                      <input type="number" class="form-control" placeholder="bp_diastolic" name="bp_diastolic" value="{{ $appointment->bp_diastolic }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_temperature" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Temp</label>
                                  <div class="col-xl-8">
                                      <input type="number" class="form-control" placeholder="F" name="temperature" value="{{ $appointment->temperature }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_weight" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Weight</label>
                                  <div class="col-xl-8">
                                      <input type="number" class="form-control" placeholder="kg" name="weight" value="{{ $appointment->weight }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_height" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Height</label>
                                  <div class="col-xl-8">
                                      <input type="number" class="form-control" placeholder="feet" name="height" value="{{ $appointment->height }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_bmi" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">BMI</label>
                                  <div class="col-xl-8">
                                      <input type="number" class="form-control" placeholder="BMI" name="bmi" value="{{ $appointment->bmi }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_respiratory_rate" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">R/R</label>
                                  <div class="col-xl-8">
                                      <input type="number" class="form-control" placeholder="R/R" name="rr" value="{{ $appointment->rr }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_ofc" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">OFC</label>
                                  <div class="col-xl-8">
                                      <input type="number" class="form-control" placeholder="OFC" name="ofc" value="{{ $appointment->ofc }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_bsa" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">BSA</label>
                                  <div class="col-xl-8">
                                      <input type="number" class="form-control" placeholder="BSA" name="bsa" value="{{ $appointment->bsa }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_us_ls_ratio" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Us/Ls Ratio</label>
                                  <div class="col-xl-4">
                                      <input type="number" class="form-control" placeholder="US" name="us_ratio" value="{{ $appointment->us_ratio }}">
                                  </div>
                                  <div class="col-xl-4">
                                      <input type="number" class="form-control" placeholder="LS" name="ls_ratio" value="{{ $appointment->ls_ratio }}">
                                  </div>
                              </div>
                          </div>

                          <div id="cp_other_oe" style="" class="col-md-4">
                              <div class="mb-1 row">
                                  <label for="" class="col-xl-4 col-form-label">Others</label>
                                  <div class="col-xl-8">
                                      <input type="text" class="form-control" placeholder="Other" name="other_oe" value="{{ $appointment->other_oe }}">
                                  </div>
                              </div>
                          </div>
                        </div>


                      </div>
                      <!-- End tab -->
                      <!-- Start tab -->
                      <div class="tab-pane fade" id="systemic_examination_tab" role="tabpanel">
                        <div class="row g-3">
                          <div class="col-md-6">
                            <div class="d-flex mb-3 justify-content-between">
                              <h6 class="mb-0">Systemic Examination</h6>
                              <div>
                                <button class="btn btn-outline-danger btn-xs ms-2" onclick="openFavouriteComponentsModal('on_examination'); return false;">
                                  <i class="ti ti-heart"></i>
                                </button>
                                <button class="btn btn-outline-info btn-xs ms-2" onclick="openTemplatedComponentsModal('on_examination'); return false;">
                                  <i class="ti ti-file-certificate"></i>
                                </button>
                                <button class="btn btn-outline-info btn-xs ms-2" onclick="openPreviousClinicalComponentsModal('on_examination'); return false;">
                                  <i class="ti ti-arrow-back-up"></i>
                                </button>
                              </div>
                            </div>

                            <select name="on_examination-component_select" class="form-control component_select2">
                              <option value=""></option>
                            </select>
                            <textarea class="form-control mt-3" name="on_examination" id="on_examination" rows="14" spellcheck="false">{{ $appointment->on_examination }}</textarea>
                          </div>

                          <div class="col-md-6">
                            <div class="d-flex mb-3 justify-content-between">
                              <h6 class="mb-0">Examination Image</h6>
                              <div>
                                <button class="btn btn-outline-danger btn-sm ms-2" onclick="openMediaGalleryModal(); return false;">
                                  Image Gallery
                                </button>
                              </div>
                            </div>
                            <div id="examination_image_container">
                              @if ($appointment->image)
                                <img src="{{ asset($appointment->image) }}" alt="" style="max-height: 300px; max-width:300px;">
                              @else
                                <p>No image uploaded</p>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End tab -->
                    </div>
                  </div>  


                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev waves-effect">
                        <i class="ti ti-arrow-left me-sm-1"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next waves-effect waves-light">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                        <i class="ti ti-arrow-right"></i>
                    </button>
                  </div>
                </div>
              </div>
              @endif
              <!-- Investigation -->
              @if($personal_settings->prescription_investigation_tab)
              <div id="investigations_step" class="content dstepper-block">
                <div class="content-header mb-3 d-flex justify-content-between">
                  <h6 class="mb-0">Investigations</h6>
                  <div>
                    <button class="btn btn-outline-danger btn-xs ms-2" onclick="openFavouriteComponentsModal('investigations'); return false;">
                      <i class="ti ti-heart"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openTemplatedComponentsModal('investigations'); return false;">
                      <i class="ti ti-file-certificate"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openPreviousClinicalComponentsModal('investigations'); return false;">
                      <i class="ti ti-arrow-back-up"></i>
                    </button>
                  </div>
                </div>

                <div class="row g-3">
                  <!-- Forms Inputs -->
                  <div class="col-md-12">
                    <select name="investigations-component_select" class="form-control component_select2">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <textarea class="form-control" name="investigations" id="investigations" rows="14" spellcheck="false">{{ $appointment->investigations }}</textarea>
                  </div>
                  <!-- End Forms Inputs -->

                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev waves-effect">
                        <i class="ti ti-arrow-left me-sm-1"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <div>
                      <button class="btn btn-primary btn-next waves-effect waves-light">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
              @endif
              <!-- Diagnosis -->
              @if($personal_settings->prescription_diagnosis_tab)
              <div id="diagnosis_step" class="content dstepper-block">
                <div class="content-header mb-3 d-flex justify-content-between">
                  <h6 class="mb-0">Diagnosis</h6>
                  <div>
                    <button class="btn btn-outline-danger btn-xs ms-2" onclick="openFavouriteComponentsModal('diagnosis'); return false;">
                      <i class="ti ti-heart"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openTemplatedComponentsModal('diagnosis'); return false;">
                      <i class="ti ti-file-certificate"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openPreviousClinicalComponentsModal('diagnosis'); return false;">
                      <i class="ti ti-arrow-back-up"></i>
                    </button>
                  </div>
                </div>

                <div class="row g-3">
                  <!-- Forms Inputs -->
                  <div class="col-md-12">
                    <select name="diagnosis-component_select" class="form-control component_select2">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <textarea class="form-control" name="diagnosis" id="diagnosis" rows="14" spellcheck="false">{{ $appointment->diagnosis }}</textarea>
                  </div>
                  <!-- End Forms Inputs -->

                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev waves-effect">
                        <i class="ti ti-arrow-left me-sm-1"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <div>
                      <button class="btn btn-primary btn-next waves-effect waves-light">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
              @endif
              <!-- Procedure -->
              @if($personal_settings->prescription_procedure_tab)
              <div id="procedure_step" class="content dstepper-block">
                <div class="content-header mb-3 d-flex justify-content-between">
                  <h6 class="mb-0">Procedures</h6>
                  <div>
                    <button class="btn btn-outline-danger btn-xs ms-2" onclick="openFavouriteComponentsModal('procedure'); return false;">
                      <i class="ti ti-heart"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openTemplatedComponentsModal('procedure'); return false;">
                      <i class="ti ti-file-certificate"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openPreviousClinicalComponentsModal('procedure'); return false;">
                      <i class="ti ti-arrow-back-up"></i>
                    </button>
                  </div>
                </div>

                <div class="row g-3">
                  <!-- Forms Inputs -->
                  <div class="col-md-12">
                    <select name="procedure-component_select" class="form-control component_select2">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <textarea class="form-control" name="procedure" id="procedure" rows="14" spellcheck="false">{{ $appointment->procedure }}</textarea>
                  </div>
                  <!-- End Forms Inputs -->

                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-label-secondary btn-prev waves-effect">
                        <i class="ti ti-arrow-left me-sm-1"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <div>
                      <button class="btn btn-primary btn-next waves-effect waves-light">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                          <i class="ti ti-arrow-right"></i>
                      </button>
                    </div>
                  </div>

                </div>
              </div>
              @endif

            </form>
          </div>
          <!-- End Page 1 steps -->

        </div>
      </div>
      <!-- End Page 1 tab -->

      <!-- Page 2 tab -->
      <div class="tab-pane fade" id="medication_and_others_tab" role="tabpanel">
        <div class="row py-3">
          <div class="col-md-9 border rounded p-3">
            <div class="content-header mb-4 d-flex justify-content-between">
              <h6 class="mb-0">Medications</h6>
              <div>
                <button class="btn btn-outline-danger btn-xs ms-2" onclick="openFavouriteMedicineModal(); return false;">
                  <i class="ti ti-heart"></i>
                </button>
                <button class="btn btn-outline-info btn-xs ms-2"  onclick="openTemplatedMedicineModal(); return false;">
                  <i class="ti ti-file-certificate"></i>
                </button>
                <button class="btn btn-outline-info btn-xs ms-2"  onclick="openPreviousMedicineModal(); return false;">
                  <i class="ti ti-arrow-back-up"></i>
                </button>
              </div>
            </div>

            <div class="row">
              
                <form class="row" method="POST" id="medication_form">
                  <div class="col-md-3 mb-1 p-0">
                      <select class="select3 form-select" id="medicine" name="medicine">
                          <option value="">Select Medicine</option>
                          @foreach ($brands as $row)
                              <option
                                  value="{{ $row->name . ' (' . $row->generic?->name . ') ' . $row->type . '-' . $row->strength }}">
                                  {{ $row->name . ' (' . $row->generic?->name . ') ' . $row->type . '-' . $row->strength }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-2 mb-1 p-0">
                      <select class="select3 form-select" id="dose" name="dose">
                          <option value="">Select doses</option>
                          @foreach ($doses as $row)
                              <option value="{{ $row->name_en }}">{{ $row->name_en }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-2 mb-1 p-0">
                      <select class="select3 form-select" id="instruction" name="instruction">
                          <option value="">Select Instruction</option>
                          @foreach ($instructions as $row)
                              <option value="{{ $row->name_en }}">{{ $row->name_en }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-2 mb-1 p-0">
                      <select class="select3 form-select" id="duration" name="duration">
                          <option value="">Select Duration</option>
                          @foreach ($durations as $row)
                              <option value="{{ $row->name_en }}">{{ $row->name_en }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-md-2 mb-1 p-0">
                      <input type="text" id="note" class="form-control" name="note"
                          placeholder="Note" />
                  </div>

                  <div class="col-md-1 p-0">
                      <button  class="btn btn-sm btn-primary px-2" onclick="saveMedication(false); return false;"><i class="ti ti-plus"></i></button>
                      <button  class="btn btn-sm btn-primary px-2" onclick="saveMedication(true); return false;"><i class="ti ti-heart"></i></button>
                  </div>
                </form>




                <div class="col-md-12 mb-1">
                    <table class="table" id="medication_table">
                        <thead>
                            <tr>
                                <th width="24%">Medicine</th>
                                <th width="17%">Dose</th>
                                <th width="17%">Instruction</th>
                                <th width="17%">Duration</th>
                                <th>Note</th>
                                <th width="50px">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button class="btn btn-info" onclick="saveAsTemplate()">Save as template</button>
                </div>

            </div>

          </div>
          <div class="col-md-3">
            <div class="row">
              <form class="col-md-12" onsubmit="saveAppointmentData(); return false;">
                <div class="content-header mb-3 d-flex justify-content-between">
                  <h6 class="mb-0">Advices</h6>
                  <div>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openTemplatedComponentsModal('advice'); return false;">
                      <i class="ti ti-file-certificate"></i>
                    </button>
                    <button class="btn btn-outline-info btn-xs ms-2" onclick="openPreviousClinicalComponentsModal('advice'); return false;">
                      <i class="ti ti-arrow-back-up"></i>
                    </button>
                  </div>
                </div>

                <div class="row g-3">
                  <!-- Forms Inputs -->
                  <div class="col-md-12">
                    <textarea class="form-control" name="advice" id="advice" rows="10" spellcheck="false">{{ $appointment->advice }}</textarea>
                  </div>
                  <!-- End Forms Inputs -->
                  <h6 class="mb-0">Follow-up date</h6>

                  <div class="col-md-12">
                    <input type="text" class="form-control" name="follow_up" value="{{ $appointment->follow_up }}">
                  </div>

                  <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-info waves-effect">
                        <span class="align-middle d-sm-inline-block d-none">Save</span>
                    </button>
                  </div>
                </div>
              </form>

              
            </div>
          </div>
        </div>
      </div>
      <!-- End Page 2 tab -->
      
    </div>
    <!-- End Pages tab content -->

  </div>




  
@endsection


@section('script')
  <script>
    /*
    * Bootstrap steper button initialization 
    * Clinical components select2 option initialization 
    * Add selected component to components textarea field
    * Save Patients update values - Patient's Info form submit
    * Save appointments update values - from onsubmit action of  all appointments releted forms
    * Open favourite components modal and load data in DataTable
    * Open previous clinical components modal and load data in DataTable
    * Open Media gallery modal and load media images
    * Upload new image to media library
    * Add media library content to appointment 
    * Show patient's Medication in datatable
    * Add patient's Medication 
    * Delete patient's Medication 
    * Save patient's Medications as a new template (Form modal open and submit)
    * Open templated medicine modal and load data in DataTable
    * Add templated medicine to appointmented patient
    * Open favourite medicine modal and load data in DataTable
    * Open previous medicine modal and load data in DataTable
    * 
    * 
    
    */
   
    // Bootstrap steper button initialization 
    $(function(){
      let e = document.querySelector(".vertical-stepper-of-clinical-components");
      if (null !== e) {
        ( t = [].slice.call(e.querySelectorAll(".btn-next"))),
        ( l = [].slice.call(e.querySelectorAll(".btn-prev")));
        const n = new Stepper(e, { linear: !1 });
        t &&
            t.forEach((e) => {
              e.addEventListener("click", (e) => {
                n.next();
              });
            }),
            l &&
                l.forEach((e) => {
                  e.addEventListener("click", (e) => {
                    n.previous();
                  });
                });
      }

    });
    
    // Clinical components select2 option initialization
    $(".component_select2").each(function () {
      let e = $(this);
      let component_type = e.attr('name').split('-')[0];
      e.wrap('<div class="position-relative"></div>').select2({
        ajax: {
          url: `{{ route('clinical_components.select_option_search', ':component_type') }}`.replace(':component_type', component_type),
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: params.term
            };
          },
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name_en,
                        id: item.name_en
                    }
                })
            };
          },
          cache: true
        },
        placeholder: 'Type 2 or more letters...',
        dropdownParent: e.parent(),
        minimumInputLength: 2,
        allowClear: true,
      }).on('select2:select', function() {
        addSelectedComponentToTextArea(component_type, e.val());
        e.val("").trigger('change');
      });
    }); 
    // Add selected component to components textarea field
    function addSelectedComponentToTextArea(textarea_name, textarea_value) {
      let text_area = $(`textarea[name="${textarea_name}"]`);
      let current_value = text_area.val();
      text_area.val(current_value + textarea_value + "\n");
      text_area.focus();
      toastr['success']('Added successfully!', 'Success!');
    }
    // End select2

    // Save Patients update values - Patient's Info form submit
    $(function(){
      let form_patients_info = $('#form_patients_info');
      let patients_info_modal = $('#patients_info_modal');
      form_patients_info.on('submit', function(e) {
        let formData = new FormData(this);
        if (!e.isDefaultPrevented()) {
          $.ajax({
            url: `{{ route('patients.update', $appointment->patient->id) }}`,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
              toastr[data.type](data.message, data.title);
              patients_info_modal.modal('hide');
            },
            error: function() {
              toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
            }
          });
          return false;
        }
      });
    })
    // End Patient's Info form submit

    // Save appointments update values - from onsubmit action of  all appointments releted forms
    function saveAppointmentData() {
      event.preventDefault();
      let formData = $(event.target).serialize();
      $.ajax({
        url: "{{ route('appointments.update', $appointment->id) }}",
        type: "PATCH",
        data: formData,
        dataType: "json",
        success: (data) => {
          toastr[data.type](data.message, data.title);
        },
        error: function() {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    }
    // End function

    // Open favourite components modal and load data in DataTable
    let favourite_components_table;
    function openFavouriteComponentsModal(component_type) {
      let request_url = `{{ route('clinical_components.get_favourites', ':component_type') }}`.replace(':component_type', component_type);
      if (!favourite_components_table) {
        favourite_components_table = $('#favourite_components_table').DataTable({
          ajax: request_url,
          processing:true,
          serverSide:true,
          columns: [
              {data: 'DT_RowIndex', searchable: false, orderable: false},
              { data: "name_en" },
              { data: (row) => {
                      return (`
                          <div class="dropdown">
                              <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick='addSelectedComponentToTextArea("${row.component_type}", ${JSON.stringify(row.name_en)} )'><i class="ti ti-plus me-1"></i> Add </a>
                          </div>
                      `);
                  } 
              },
          ],

          columnDefs: [
              { 
                  'searchable'    : false, 
                  'targets'       : [2] 
              },
          ],
          pageLength: 5,
          responsive: true,
        });
      }else {
        favourite_components_table.ajax.url(request_url).load();
      }
      $('#favourite_components_modal_title').text('Favourite ' + component_type.split('_').join(' '));
      $('#favourite_components_modal').modal('show');
    };

    // Open  components templates modal and load data in DataTable
    let components_templates_table;
    function openTemplatedComponentsModal(template_type) {
      let request_url = `{{ route('components_templates', ':template_type') }}`.replace(':template_type', template_type);
      if (!components_templates_table) {
        components_templates_table = $('#components_templates_table').DataTable({
          ajax: request_url,
          processing:true,
          serverSide:true,
          columns: [
              {data: 'DT_RowIndex', searchable: false, orderable: false},
              { data: "name" },
              { data: (row) => {
                      return (`
                          <div class="dropdown">
                              <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick='addSelectedComponentToTextArea("${row.template_type}", ${JSON.stringify(row.template_en)} )'><i class="ti ti-plus me-1"></i> Add </a>
                          </div>
                      `);
                  } 
              },
          ],

          columnDefs: [
              { 
                  'searchable'    : false, 
                  'targets'       : [2] 
              },
          ],
          pageLength: 5,
          responsive: true,
        });
      }else {
        components_templates_table.ajax.url(request_url).load();
      }
      $('#components_templates_modal_title').text('Templated ' + template_type.split('_').join(' '));
      $('#components_templates_modal').modal('show');
    };

    // Open previous clinical components modal and load data in DataTable
    let previous_clinical_components_table;
    function openPreviousClinicalComponentsModal(component_type) {
      let request_url = `{{ route('appointments.previous_appointments', ['patient_id' => $appointment->patient_id, 'appointment_no' => $appointment->appointment_no ]) }}`;
      //$('#equictntbl').DataTable().clear().destroy();
      if(previous_clinical_components_table){
        $('#previous_clinical_components_table').DataTable().clear().destroy();
      }
      previous_clinical_components_table = $('#previous_clinical_components_table').DataTable({
        ajax: request_url,
        processing:true,
        serverSide:true,
        columns: [
          { data: 'appointment_no' },
          { data: component_type },
          { data: (row) => {
              return (`
                  <div class="dropdown">
                      <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick='addSelectedComponentToTextArea("${component_type}", ${JSON.stringify(row[component_type])} )'><i class="ti ti-plus me-1"></i> Add </a>
                  </div>
              `);
            } 
          },
        ],

        columnDefs: [
            { 
                'searchable'    : false, 
                'targets'       : [2] 
            },
        ],
        pageLength: 5,
        responsive: true,
      });
      
      $('#previous_clinical_components_modal_title').text('Previous ' + component_type.split('_').join(' '));
      $('#previous_clinical_components_modal').modal('show');
    };

    
    // Open Media gallery modal and load media images
    function openMediaGalleryModal() {
      let media_url = `{{ route('media_libraries.all_media') }}`;
      $.ajax({
        url: media_url,
        type: "GET",
        dataType: "json",
        success: (data) => {
          if (data.success === true) {
              let media_data = data.media;
              let media_html = '';
              media_data.forEach(function(media) {
                  media_html += `
                      <div class="col-md-3 gallery-item" style="position:relative; overflow:hidden;" >
                          <img style="width:100%; height:100%" src="{{ asset('') }}${media.path}">
                          <div class="media-overlay">
                              <p class="text-light">${media.name}</p>
                              <button href="#" onclick="addMediaToPrescription('${media.path}')" class="btn  btn-outline-light">Add</button>
                          </div>
                      </div>
                  `;
              });

              $('#media_library_content').html(media_html);

              $('#media_library_modal').modal('show');

          } else {
              console.log(error);
          }
        },
        error: function() {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    };
    // Upload new image to media library
    $('#new_media').on('change', function(e) {
        $('#new_media_form').submit();
    });
    $('#new_media_form').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ route('media_libraries.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (data) => {
                if (data.success) {
                    let media_data = data.media;
                    let media_html = '';
                    media_data.forEach(function(media) {
                        media_html += `
                            <div class="col-md-3 gallery-item" style="position:relative; overflow:hidden;" >
                                <img style="width:100%; height:100%" src="{{ asset('') }}${media.path}">
                                <div class="media-overlay">
                                    <p class="text-light">${media.name}</p>
                                    <button href="#" onclick="addMediaToPrescription('${media.path}')" class="btn  btn-outline-light">Add</button>
                                </div>
                            </div>
                        `;
                    });

                    $('#media_library_content').html(media_html);
                } else {
                  toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
                }
                $('#new_media_form')[0].reset();
            },
            error: function(response) {
              toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
            }
        });
    });
    // Add media library content to appointment 
    function addMediaToPrescription(path){
      $.ajax({
        url: "{{ route('appointments.update', $appointment->id) }}",
        type: "PATCH",
        data: {image: path},
        dataType: "json",
        success: (data) => {
          toastr[data.type](data.message, data.title);
          $('#examination_image_container').html(
              `<img src="{{ asset('/') }}${path}"  style="max-height: 300px; max-width:300px;">`
          );
          $('#media_library_modal').modal('hide');
        },
        error: function() {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    }

    // Show patient's Medication in datatable
    let medication_table = $('#medication_table').DataTable({
      ajax: `{{ route('medications.get_medications', $appointment->id ) }}`,
      processing:true,
      serverSide:true,
      columns: [
          { data: "medicine" },
          { data: "dose" },
          { data: "instruction" },
          { data: "duration" },
          { data: "note" },
          { data: (row) => {
                  return (`
                          <button class="btn btn-danger btn-xs" onclick="deleteMedication(${row.id})" ><i class="ti ti-trash"></i></button>
                  `);
              } 
          },
      ],
      searching: false, paging: false, info: false,
      pageLength: 100,
      responsive: false,
    });
    // Add patient's Medication & Favourite Medication
    function saveMedication(favourite) {
      let formData = $('#medication_form').serialize();
      let uri = "{{ route('medications.store', $appointment->id) }}";
      if(favourite){
        uri = "{{ route('medications.add_to_favourite') }}";
      }
      $.ajax({
        type: 'POST',
        url: uri,
        data: formData,
        dataType: "json",
        success: (data) => {
            if (data.success) {
              medication_table.ajax.reload();
              $('#medication_form')[0].reset();
              $( ".select3" ).val('').trigger('change');
            }
            toastr[data.type](data.message, data.title);
        },
        error: function(response) {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    }
    // Delete patient's Medication 
    function deleteMedication(id) {
      $.ajax({
        url: `{{route('medications.destroy', ':id')}}`.replace(':id', id),
        type: 'POST',
        data: {'_method': 'DELETE',},
        success: function(data) {
          if (data.success === true) {
            medication_table.ajax.reload();
          } 
          toastr[data.type](data.message, data.title);
        },
        error: function() {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    }

    // Save patient's Medications as a new template (Form modal open and submit)
    function saveAsTemplate(appointment_id)
    {
      $('#medicine_template_form')[0].reset();
      $('#medicine_template_form_modal').modal('show');
    }
    $('#medicine_template_form').on('submit', function(e){
      e.preventDefault();
      let form_data = $(e.target).serialize();
      $.ajax({
        type: 'POST',
        url: "{{ route('medicine_template.store') }}",
        data: form_data,
        dataType: "json",
        success: (data) => {
          toastr[data.type](data.message, data.title);
          $('#medicine_template_form_modal').modal('hide');
        },
        error: function(response) {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    })


    // Open templated medicine modal and load data in DataTable
    let templated_medicine_table;
    function openTemplatedMedicineModal() {
      let request_url = `{{ route('medicine_template.index') }}`;
      //$('#equictntbl').DataTable().clear().destroy();
      if(templated_medicine_table){
        templated_medicine_table.ajax.url(request_url).load();
      }else{
        templated_medicine_table = $('#templated_medicine_table').DataTable({
          ajax: request_url,
          processing:true,
          serverSide:true,
          columns: [
            { data: 'name' },
            { data: (row) => {
                return (`
                  <div class="dropdown">
                    <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick='addTemplatedMedicineToAppointment("${row.id}")'><i class="ti ti-plus me-1"></i> Add </a>
                  </div>
                `);
              } 
            },
          ],

          columnDefs: [
              { 
                  'searchable'    : false, 
                  'targets'       : [1] 
              },
          ],
          pageLength: 5,
          responsive: true,
        });
        $('#templated_medicine_modal').modal('show');
      }
    };
    // Add templated medicine to appointmented patient
    function addTemplatedMedicineToAppointment(medicine_template_id){
      let form_data = {medicine_template_id: medicine_template_id, appointment_id: {{ $appointment->id }} };
      $.ajax({
        type: 'POST',
        url: "{{ route('medicine_template.add_to_appointment') }}",
        data: form_data,
        dataType: "json",
        success: (data) => {
          toastr[data.type](data.message, data.title);
          $('#medicine_template_form_modal').modal('hide');
          medication_table.ajax.reload();
        },
        error: function(response) {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    }

    // Add templated medicine to appointmented patient
    function addFavouriteMedicineToAppointment(favourite_medication_id){
      let form_data = {favourite_medication_id: favourite_medication_id, appointment_id: {{ $appointment->id }} };
      $.ajax({
        type: 'POST',
        url: "{{ route('favourite_medications.add_to_appointment') }}",
        data: form_data,
        dataType: "json",
        success: (data) => {
          toastr[data.type](data.message, data.title);
          $('#medicine_template_form_modal').modal('hide');
          medication_table.ajax.reload();
        },
        error: function(response) {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    }
    
    // Open favourite medicine modal and load data in DataTable
    let favourite_medicine_table;
    function openFavouriteMedicineModal() {
      let request_url = `{{ route('medications.get_favourite') }}`;
      if(favourite_medicine_table){
        favourite_medicine_table.ajax.url(request_url).load();
      }else{
        favourite_medicine_table = $('#favourite_medicine_table').DataTable({
          ajax: request_url,
          processing:true,
          serverSide:true,
          columns: [
            { data: 'medicine' },
            { data: 'dose' },
            { data: 'instruction' },
            { data: 'duration' },
            { data: 'note' },
            { data: (row) => {
                return (`
                  <div class="dropdown">
                    <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick='addFavouriteMedicineToAppointment("${row.id}")'><i class="ti ti-plus me-1"></i> Add </a>
                  </div>
                `);
              } 
            },
          ],

          columnDefs: [
              { 
                  'searchable'    : false, 
                  'targets'       : [5] 
              },
          ],
          pageLength: 10,
          responsive: true,
        });
      }
      $('#favourite_medicine_modal').modal('show');
    };

    // Open previous medicine modal and load data in DataTable
    let previous_medication_table;
    function openPreviousMedicineModal() {
      let request_url = `{{ route('medications.get_previous_medications', $appointment->id ) }}`;
      if(previous_medication_table){
        previous_medication_table.ajax.url(request_url).load();
      }else{
        previous_medication_table = $('#previous_medication_table').DataTable({
          ajax: request_url,
          processing:true,
          serverSide:true,
          columns: [
            { data: 'medicine' },
            { data: 'dose' },
            { data: 'instruction' },
            { data: 'duration' },
            { data: 'note' },
            { data: (row) => {
                return (`
                  <div class="dropdown">
                    <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick='addPreviousMedicineToAppointment("${row.id}")'><i class="ti ti-plus me-1"></i> Add </a>
                  </div>
                `);
              } 
            },
          ],

          columnDefs: [
              { 
                  'searchable'    : false, 
                  'targets'       : [5] 
              },
          ],
          pageLength: 10,
          responsive: true,
        });
      }
      $('#previous_medication_modal').modal('show');
    };
  
    
    // Add templated medicine to appointmented patient
    function addPreviousMedicineToAppointment(medication_id){
      let form_data = {medication_id: medication_id, appointment_id: {{ $appointment->id }} };
      $.ajax({
        type: 'POST',
        url: "{{ route('previous_medications.add_to_appointment') }}",
        data: form_data,
        dataType: "json",
        success: (data) => {
          toastr[data.type](data.message, data.title);
          $('#medicine_template_form_modal').modal('hide');
          medication_table.ajax.reload();
        },
        error: function(response) {
          toastr['warning']('Oops, something went wrong. Please try again.', 'Warning!');
        }
      });
    }
  </script>
@endsection