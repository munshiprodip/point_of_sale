@extends('layouts.datatable')
@section('title', 'Product List')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>SKU</th>
                        <th>NAME</th>
                        <th>PURCHASE PRICE</th>
                        <th>SALE PRICE</th>
                        <th>STOCK</th>
                        <th>OPTIONS</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
    <!--/ Responsive Datatable --> 
@endsection


@section('script')
    <script>
        let data_table          = $("#data_table");

        $(function(){
            data_table = data_table.DataTable({
                ajax: "{{ route('products.list') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "sku" },
                    { data: "name" },
                    { data: (row) => {
                            return `
                                @canany(['Create Purchases'])
                                    ${row.purchase_price}
                                @endcanany
                            `;
                        } 
                    },
                    { data: "sale_price" },
                    { data: "stock_quantity" },
                    { data: (row) => {
                        
                            return `
                                @canany(['Edit Products', 'Delete Products'])
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                        <div class="dropdown-menu">
                                            @can('Edit Products')
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="editData(${row.id})"><i class="ti ti-pencil me-1"></i> Edit</a>
                                            @endcan
                                            @can('Delete Products')
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="deleteData(${row.id})"><i class="ti ti-trash me-1"></i> Delete</a>
                                            @endcan
                                        </div>
                                    </div>
                                @endcanany
                            `;
                        } 
                    },
                ],

                columnDefs: [
                    { 
                        'searchable'    : false, 
                        'targets'       : [3, 6] 
                    },
                    {
                        'orderable': false,
                        'targets'       : [3, 6] 
                    }
                ],
                @can('Create Products')
                    dom: '<"row mx-1"<"col-sm-12 col-md-3" l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    buttons: [
                        {
                        text: "ADD NEW PRODUCT",
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

        @can('Create Products')
            function addData(){
                window.location.href = `{{ route("products.create") }}`;
            }
        @endcan
        @can('Edit Products')
            function editData(id){
                window.location.href = `{{ route("products.edit", ":id") }}`.replace(':id', id);
            }
        @endcan

        @can('Delete Products')
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
                            url: `{{route('products.destroy', ':id')}}`.replace(':id', id),
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
        @endcan

        
    </script>
@endsection