@extends('layouts.datatable')
@section('title', 'Cash Deposites')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>USER</th>
                        <th>DESCRIPTION</th>
                        <th>AMOUNT</th>
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
                <h5 id="offcanvasEndLabel" class="offcanvas-title">NEW DEPOSITE</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                <form id="add_data_form" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label">AMOUNT</label>
                        <input name="amount" type="number" class="form-control" value="1" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">DESCRIPTION</label>
                        <input name="description" type="text" class="form-control"/>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Save</button>
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
        let add_data_form       = $("#add_data_form");

        $(function(){
            data_table = data_table.DataTable({
                ajax: "{{ route('cash_deposites.list') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "user_name" },
                    { data: "description" },
                    { data: "amount" },
                    { data: (row) => {
                            return `
                                @can('Cash Receive')
                                    <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="verify(${row.id})">Receive</a>
                                @endcan
                            `;
                        } 
                    },
                ],

                @can('Create Cash Deposite')
                    dom: '<"row mx-1"<"col-sm-12 col-md-3" l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    buttons: [
                        {
                        text: "NEW DEPOSITE",
                        className: "add-new btn btn-primary btn-sm mb-3 mb-md-0",
                        attr: {
                            "onclick": "addData()",
                        },
                        init: function (e, a, t) {
                            $(a).removeClass("btn-secondary");
                        },
                        },
                    ],
                @endcan

                pageLength: 25,
                responsive: true,
            });

            
        });
        
        function addData(){
            add_data_form.trigger("reset");
            add_data_canvas.offcanvas('show');
        }


        // submit add-new-data form
        add_data_form.on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                $.ajax({
                    url: `{{ route('cash_deposites.store') }}`,
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


        function verify(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to receive this deposite?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, Verify!",
                cancelButtonText: "No, cancel!",
                customClass: {
                    confirmButton: "btn btn-primary me-3",
                    cancelButton: "btn btn-label-secondary",
                },
            }).then(
                function (t) {
                if(t.value){
                    $.ajax({
                        url: `{{route('cash_deposites.verify')}}`,
                        type: 'POST',
                        data: {id: id},
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