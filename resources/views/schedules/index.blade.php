@extends('layouts.datatable')
@section('title', 'Schedules')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>NAME</th>
                        <th>START TIME</th>
                        <th>END TIME</th>
                        <th>DAY OFF</th>
                        <th>STATUS</th>
                        <th>OPTIONS</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Add data Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="add_data_canvas" aria-labelledby="add_data_canvas_label">
            <div class="offcanvas-header pb-0">
                <h5 id="offcanvasEndLabel" class="offcanvas-title">NEW ENTRY</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                <form id="add_data_form" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Name"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input name="start_time" type="text" class="form-control flatpickr-input pick-time" placeholder="00:00 AM"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input name="end_time" type="text" class="form-control flatpickr-input pick-time" placeholder="12:00 PM"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Weekly Holiday</label>
                    
                        <div class="form-check offset-2 me-lg-5">
                            <input name="saturday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Saturday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="sunday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Sunday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="monday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Monday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="tuesday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Tuesday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="wednesday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Wednesday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="thursday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Thursday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="friday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Friday
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Save</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Edit data Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="edit_data_canvas" aria-labelledby="edit_data_canvas_label">
            <div class="offcanvas-header pb-0">
                <h5 id="offcanvasEndLabel" class="offcanvas-title">EDIT DATA</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                <form id="edit_data_form" >
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" placeholder="Name"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input name="start_time" type="text" class="form-control" placeholder="00:00 AM"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input name="end_time" type="text" class="form-control" placeholder="12:00 PM"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Weekly Holiday</label>
                    
                        <div class="form-check offset-2 me-lg-5">
                            <input name="saturday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Saturday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="sunday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Sunday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="monday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Monday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="tuesday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Tuesday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="wednesday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Wednesday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="thursday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Thursday
                            </label>
                        </div>
                        <div class="form-check offset-2 me-lg-5">
                            <input name="friday" value="1" class="form-check-input" type="checkbox" >
                            <label class="form-check-label" >
                                Friday
                            </label>
                        </div>
                    </div>
                    <input name="id" id="edit_data_id" type="hidden" />
                    <button type="submit" class="btn btn-outline-primary">Send</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>
    <!--/ Responsive Datatable --> 
@endsection


@section('script')
    <script>
        let data_table          = $("#data_table");
        let add_data_canvas     = $("#add_data_canvas");
        let edit_data_canvas    = $("#edit_data_canvas");
        let add_data_form       = $("#add_data_form");
        let edit_data_form      = $("#edit_data_form");

        $(function(){
            data_table = data_table.DataTable({
                ajax: "{{ route('schedules') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "name" },
                    { data: "start_time" },
                    { data: "end_time" },
                    { data: (row) => {
                        let dayOff = '';
                        dayOff += row.saturday? 'Saturday, ': '';
                        dayOff += row.sunday? 'Sunday, ': '';
                        dayOff += row.monday? 'Monday, ': '';
                        dayOff += row.tuesday? 'Tuesday, ': '';
                        dayOff += row.wednesday? 'Wednesday, ': '';
                        dayOff += row.thursday? 'Thursday, ': '';
                        dayOff += row.friday? 'Friday, ': '';

                            return dayOff;
                        }
                    },
                    { data: (row) => {
                            return `<span style="cursor:pointer;" class="badge me-1 bg-label-${row.status===1? 'danger':'info'}" onclick="changeStatus(${row.id})" > ${row.status===1? 'Activated':'Deactivated'}</span>`;
                        }
                    },
                    { data: (row) => {
                        
                            return `
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editData(${row.id})"><i class="ti ti-pencil me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="deleteData(${row.id})"><i class="ti ti-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            `;
                        } 
                    },
                ],

                columnDefs: [
                    { 
                        'searchable'    : false, 
                        'targets'       : [4,5] 
                    },
                ],
                dom: '<"row mx-1"<"col-sm-12 col-md-3" l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [
                    {
                    text: "ADD NEW",
                    className: "add-new btn btn-primary btn-sm mb-3 mb-md-0",
                    attr: {
                        "onclick": "addData()",
                    },
                    init: function (e, a, t) {
                        $(a).removeClass("btn-secondary");
                    },
                    },
                ],
                pageLength: 25,
                responsive: true,
            });

            
        });
        
        function addData(){
            add_data_form.trigger("reset");
            add_data_canvas.offcanvas('show');
        }

        

        function editData(id) {
            $.ajax({
                url: `{{ route('schedules.find', ':id' ) }}`.replace(':id', id),
                type: "GET",
                success: function ( res ) {
                    if (res.success) {
                        edit_data_form.trigger("reset");
                        edit_data_canvas.offcanvas('show');
                        edit_data_form.find("input[name='name']").val(res.data.name);
                        edit_data_form.find("input[name='start_time']").val(res.data.start_time);
                        edit_data_form.find("input[name='end_time']").val(res.data.end_time);
                        edit_data_form.find("input[name='saturday']").prop( "checked", res.data.saturday);
                        edit_data_form.find("input[name='sunday']").prop( "checked", res.data.sunday);
                        edit_data_form.find("input[name='monday']").prop( "checked", res.data.monday);
                        edit_data_form.find("input[name='tuesday']").prop( "checked", res.data.tuesday);
                        edit_data_form.find("input[name='wednesday']").prop( "checked", res.data.wednesday);
                        edit_data_form.find("input[name='thursday']").prop( "checked", res.data.thursday);
                        edit_data_form.find("input[name='friday']").prop( "checked", res.data.friday);
                        edit_data_form.find("#edit_data_id").val(res.data.id);
                    } else {
                        Swal.fire({
                            icon: res.type, // "success", "error", "warning", "info", "question" .prop( "checked", true );
                            title: res.title,
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: !1,
                        });
                        
                    }
                },
                error: function (err) {
                    Swal.fire({
                        icon: 'warning', // "success", "error", "warning", "info", "question"
                        title: "Warning!",
                        text: 'Oops, something went wrong. Please try again.',
                        timer: 1500,
                        showConfirmButton: !1,
                    });
                },
            });
        }


        // submit add-new-data form
        add_data_form.on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                $.ajax({
                    url: `{{ route('schedules.store') }}`,
                    type: "POST",
                    data: add_data_form.serialize(),
                    success: function(data) {
                        if (data.success === true) {
                            add_data_form.trigger("reset");
                            add_data_canvas.offcanvas('hide')
                            data_table.ajax.reload();
                        } 

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

                        add_data_form.trigger("reset");
                        add_data_canvas.offcanvas('hide')
                    }
                });
                return false;
            }
        });

        edit_data_form.on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                let id = $('#edit_data_id').val();
                $.ajax({
                    url: `{{ route('schedules.update', ':id') }}`.replace(':id', id),
                    type: "POST",
                    data: edit_data_form.serialize(),

                    success: function(data) {
                        if (data.success === true) {
                            edit_data_form.trigger("reset");
                            edit_data_canvas.offcanvas('hide')
                            data_table.ajax.reload();
                        } 

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

                        edit_data_form.trigger("reset");
                        edit_data_canvas.offcanvas('hide')
                    }
                });
                return false;
            }
        });

        function changeStatus(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "The status will be changed",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, confirm!",
                cancelButtonText: "No, cancel!",
                customClass: {
                    confirmButton: "btn btn-primary me-3",
                    cancelButton: "btn btn-label-secondary",
                },
            }).then(
                function (t) {
                if(t.value){
                    $.ajax({
                        url: `{{route('schedules.change_status', ':id')}}`.replace(':id', id),
                        type: 'GET',
                        success: function(data) {
                            if (data.success === true) {
                                data_table.ajax.reload();
                            } 

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
                }
            });
        }


        function deleteData(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                customClass: {
                    confirmButton: "btn btn-primary me-3",
                    cancelButton: "btn btn-label-secondary",
                },
            }).then(
                function (t) {
                if(t.value){
                    $.ajax({
                        url: `{{route('schedules.destroy', ':id')}}`.replace(':id', id),
                        type: 'POST',
                        data: {'_method': 'DELETE',},
                        success: function(data) {
                            if (data.success === true) {
                                data_table.ajax.reload();
                            } 

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
                }
            });
        }

        
    </script>
@endsection