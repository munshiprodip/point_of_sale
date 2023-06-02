@extends('layouts.datatable')
@section('title', 'Dashboard')

@section('content')
<div class="row">

    
    <div class="col-xl-12 col-md-12 col-12 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="card-title mb-1 pt-2">{{ auth()->user()->settings()->first()->org_title }}</h3>
                <p>{{ auth()->user()->settings()->first()->org_address }}</p>
            </div>
        </div>
    </div>




    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">Appointment Reports</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 d-flex flex-column align-self-end">
                        <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">
                            <div class="badge rounded bg-label-info p-1"><i class="ti ti-stethoscope ti-xl"></i></div>
                            <h1 class="mb-0">{{$total_appointments_count}}</h1>
                        </div>
                        <small class="text-muted">Appointed patients summery</small>
                    </div>
                </div>
                <div class="border rounded p-3 mt-2">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-primary p-1"><i class="ti ti-user ti-sm"></i></div>
                                <h6 class="mb-0">Todays</h6>
                            </div>
                            <h4 class="my-2 pt-1">{{$todays_appointments_count}}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-info p-1"><i class="ti ti-user ti-sm"></i></div>
                                <h6 class="mb-0">Last Week</h6>
                            </div>
                            <h4 class="my-2 pt-1">{{$weekly_appointments_count}}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1"><i class="ti ti-user ti-sm"></i></div>
                                <h6 class="mb-0">This Month</h6>
                            </div>
                            <h4 class="my-2 pt-1">{{$monthly_appointments_count}}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between mb-lg-4">
                <div class="card-title mb-0">
                    <h5 class="mb-0">Earning Reports</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 d-flex flex-column align-self-end">
                        <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">
                            <div class="badge rounded bg-label-primary p-1"><i class="ti ti-currency-dollar ti-xl"></i></div>
                            <h1 class="mb-0">{{$total_appointments_fee}}</h1>
                        </div>
                        <small class="text-muted">Your collection summery</small>
                    </div>
                </div>
                <div class="border rounded p-3 mt-2">
                    <div class="row gap-4 gap-sm-0">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-primary p-1"><i class="ti ti-currency-dollar ti-sm"></i></div>
                                <h6 class="mb-0">Todays</h6>
                            </div>
                            <h4 class="my-2 pt-1">{{$todays_appointments_fee}}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-info p-1"><i class="ti ti-currency-dollar ti-sm"></i></div>
                                <h6 class="mb-0">Last Week</h6>
                            </div>
                            <h4 class="my-2 pt-1">{{$weekly_appointments_fee}}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="badge rounded bg-label-danger p-1"><i class="ti ti-currency-dollar ti-sm"></i></div>
                                <h6 class="mb-0">This Month</h6>
                            </div>
                            <h4 class="my-2 pt-1">{{$monthly_appointments_fee}}</h4>
                            <div class="progress w-75" style="height:4px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection