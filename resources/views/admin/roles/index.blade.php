@extends('layouts.datatable')
@section('title', 'Roles')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>ASSIGNED TO</th>
                        <th>OPTIONS</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <div class="modal fade show" id="add_data_canvas" tabindex="-1" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                    <div class="modal-content p-3 p-md-5">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                            <h3 class="role-title mb-2">Add New Role</h3>
                            <p class="text-muted">Set role permissions</p>
                            </div>
                            <!-- Add role form -->
                            <form id="add_data_form" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" >
                                <div class="col-12 mb-4 fv-plugins-icon-container">
                                    <label class="form-label" for="modalRoleName">Role Name</label>
                                    <input type="text" id="modalRoleName" name="name" class="form-control" placeholder="Enter a role name" tabindex="-1">
                                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                <div class="col-12">
                                    <h5>Role Permissions</h5>
                                    <!-- Permission table -->
                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody>
                                                @foreach($permissions as $type=>$values)
                                                    <tr>
                                                        <td class="text-nowrap fw-semibold">{{ $type }}</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @foreach($values as $permission)
                                                                <div class="form-check me-3 me-lg-5">
                                                                    <input name="permissions[]" value="{{ $permission->name }}" class="form-check-input" type="checkbox" id="{{ 'permissionCheckbox_'.$permission->id }}">
                                                                    <label class="form-check-label" for="{{ 'permissionCheckbox_'.$permission->id }}">
                                                                        {{ $permission->name }}
                                                                    </label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Permission table -->
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                                    <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                </div>
                                <input type="hidden">
                            </form>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade show" id="edit_data_canvas" tabindex="-1" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                    <div class="modal-content p-3 p-md-5">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                            <h3 class="role-title mb-2">Add New Role</h3>
                            <p class="text-muted">Set role permissions</p>
                            </div>
                            <!-- Add role form -->
                            <form id="edit_data_form" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" >
                                @method('PATCH')
                                <div class="col-12 mb-4 fv-plugins-icon-container">
                                    <label class="form-label" for="modalRoleName">Role Name</label>
                                    <input type="text" id="modalRoleName" name="name" class="form-control" placeholder="Enter a role name" tabindex="-1">
                                <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                <div class="col-12">
                                    <h5>Role Permissions</h5>
                                    <!-- Permission table -->
                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody>
                                                @foreach($permissions as $type=>$values)
                                                    <tr>
                                                        <td class="text-nowrap fw-semibold">{{ $type }}</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @foreach($values as $permission)
                                                                <div class="form-check me-3 me-lg-5">
                                                                    <input name="permissions[]" value="{{ $permission->name }}" class="form-check-input" type="checkbox" id="{{ 'permissionCheckbox_'.$permission->id }}">
                                                                    <label class="form-check-label" for="{{ 'permissionCheckbox_'.$permission->id }}">
                                                                        {{ $permission->name }}
                                                                    </label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Permission table -->
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <input name="id" id="edit_data_id" type="hidden" />
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Submit</button>
                                    <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                </div>
                                <input type="hidden">
                            </form>
                            <!--/ Add role form -->
                        </div>
                    </div>
                </div>
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
                ajax: "{{ route('roles') }}",
                processing:true,
                serverSide:true,
                columns: [
                    { data: "name" },
                    { data: row => row.users.length + ' Person' },
                    { data: (row) => {
                            return (`
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editData(${row.id})"><i class="ti ti-pencil me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="deleteData(${row.id})"><i class="ti ti-trash me-1"></i> Delete</a>
                                    </div>
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
            add_data_canvas.modal('show');
        }

        

        function editData(id) {
            $.ajax({
                url: `{{ route('roles.find', ':id' ) }}`.replace(':id', id),
                type: "GET",
                success: function ( res ) {
                    if (res.success) {
                        edit_data_form.trigger("reset");
                        edit_data_canvas.modal('show');
                        edit_data_form.find("input[name='name']").val(res.role.name);
                        edit_data_form.find("input[name='permissions[]']").val(res.permissions);
                        edit_data_form.find("#edit_data_id").val(res.role.id);
                    } else {
                        Swal.fire({
                            icon: res.type, // "success", "error", "warning", "info", "question"
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
                    url: `{{ route('roles.store') }}`,
                    type: "POST",
                    data: add_data_form.serialize(),
                    success: function(data) {
                        if (data.success === true) {
                            add_data_form.trigger("reset");
                            add_data_canvas.modal('hide')
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
                        add_data_canvas.modal('hide')
                    }
                });
                return false;
            }
        });

        edit_data_form.on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                let id = $('#edit_data_id').val();
                $.ajax({
                    url: `{{ route('roles.update', ':id') }}`.replace(':id', id),
                    type: "POST",
                    data: edit_data_form.serialize(),

                    success: function(data) {
                        if (data.success === true) {
                            edit_data_form.trigger("reset");
                            edit_data_canvas.modal('hide')
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
                        edit_data_canvas.modal('hide')
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
                        url: `{{route('roles.change_status', ':id')}}`.replace(':id', id),
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
                        url: `{{route('roles.destroy', ':id')}}`.replace(':id', id),
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