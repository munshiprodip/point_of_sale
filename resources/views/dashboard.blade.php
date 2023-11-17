@extends('layouts.datatable')
@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-12 col-md-12 col-12 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="card-title mb-1 pt-2">Welcome to {{ auth()->user()->organization->name }}</h3>
                <h3 class="card-title mb-1 pt-2">Attendance Management System</h3>
            </div>
        </div>
    </div>

    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">Active Employee</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 d-flex flex-column align-self-end">
                        <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">
                            <div class="badge rounded bg-label-info p-1"><i class="ti ti-users ti-xl"></i></div>
                            <h1 class="mb-0">{{ $active_employee_count }}</h1>
                        </div>
                        <small class="text-muted">Employee summary</small>
                    </div>
                </div>
                <div class="border rounded p-3 my-2">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-3">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-primary p-1"><i class="ti ti-user ti-sm"></i></div>
                                <a href="{{route('employees')}}">
                                    <h6 class="mb-0">Total Employes</h6>
                                </a>
                            </div>
                            <h4 class="my-2 pt-1">{{ $total_employee_count }}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1"><i class="ti ti-user-check ti-sm"></i></div>
                                <a href="{{route('employees')}}">
                                    <h6 class="mb-0">Active</h6>
                                </a>
                            </div>
                            <h4 class="my-2 pt-1">{{ $active_employee_count }}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1"><i class="ti ti-user-x ti-sm"></i></div>
                                <a href="{{route('employees')}}">
                                    <h6 class="mb-0">Disabled</h6>
                                </a>
                            </div>
                            <h4 class="my-2 pt-1">{{ $disabled_employee_count }}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-info p-1"><i class="ti ti-user-minus ti-sm"></i></div>
                                <a href="#">
                                    <h6 class="mb-0">Day off</h6>
                                </a>
                            </div>
                            <h4 class="my-2 pt-1">{{ $day_off_employee_count }}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <small class="text-muted mt-3">Employee attendance summary</small>
                <div class="border rounded p-3 mt-2">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-3">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-success p-1"><i class="ti ti-user ti-sm"></i></div>
                                <a href="{{route('attendances.view')}}">
                                    <h6 class="mb-0">Present</h6>
                                </a>
                            </div>
                            <h4 class="my-2 pt-1">{{ $present_count }}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1"><i class="ti ti-user ti-sm"></i></div>
                                <h6 class="mb-0">Absent</h6>
                            </div>
                            <h4 class="my-2 pt-1">{{ $absent_count }}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-warning p-1"><i class="ti ti-user ti-sm"></i></div>
                                <a href="{{route('attendances.late_ins')}}">
                                    <h6 class="mb-0">Late In</h6>
                                </a>
                            </div>
                            <h4 class="my-2 pt-1">{{ $late_in_count }}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-secondary p-1"><i class="ti ti-user ti-sm"></i></div>
                                <a href="{{route('attendances.attendancelogs')}}">
                                    <h6 class="mb-0">In/Out</h6>
                                </a>
                            </div>
                            <h4 class="my-2 pt-1">{{ $log_count }}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection