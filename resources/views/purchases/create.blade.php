@extends('layouts.datatable')
@section('title', 'New Purchase')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">New Purchase</h5>
                <div class="card-body">
                    <form id="select_product_form">
                        <div class="row">
                            <div class="mb-3 col-md-8">
                                <label class="form-label" >Product name</label>
                                <select name="product_id" class="form-select select3" required >
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{$product->sku}} - {{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label" >Unit Price</label>
                                <input class="form-control" type="number" name="unit_price" value="0"/>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label" >Quantity</label>
                                <input class="form-control" type="number" name="quantity" value="10"/>
                            </div>

                            <div class="mt-4 col-md-2">
                                <button type="submit" class="btn btn-primary me-2 w-100">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header">Selected Products</h5>
                <div class="card-body">
                    <table class="table" id="cart_data_table">
                        <thead>
                            <tr>
                                <td>SL</td>
                                <td>SKU</td>
                                <td>PRODUCT NAME</td>
                                <td>UNIT PRICE</td>
                                <td>QUANTITY</td>
                                <td>TOTAL</td>
                                <td>OPTION</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
@endsection


@section('script')
    <script>

        let cart_data_table   = $("#cart_data_table");
        let select_product_form = $('#select_product_form');

        $(function(){
            select_product_form.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('purchases.add_to_cart') }}`,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {      
                            select_product_form.trigger("reset");
                            cart_data_table.ajax.reload();
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

            cart_data_table = cart_data_table.DataTable({
                ajax: "{{ route('purchases.create') }}",
                searching: false, 
                ordering: false, 
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "sku" },
                    { data: "name" },
                    { data: "unit_price" },
                    { data: "quantity" },
                    { data: "total_price" },
                    { data: (row) => {
                        
                            return `
                                <a class="dropdown-item" href="javascript:void(0);" onclick="deletFromCart(${row.id})"><i class="ti ti-trash me-1"></i> Remove</a>
                            `;
                        } 
                    },
                ],

                dom: '<"row mx-1"<"col-sm-12 col-md-3" l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [
                    {
                    text: "SAVE PURCHASE",
                    className: "add-new btn btn-primary btn-sm mb-3 mb-md-0",
                    attr: {
                        "onclick": "savePurchase()",
                    },
                    init: function (e, a, t) {
                        $(a).removeClass("btn-secondary");
                    },
                    },
                ],
                pageLength: 50,
                responsive: true,
            });

        });


        function deletFromCart(id) {
            $.ajax({
                url: `{{route('purchases.delete_from_cart', ':id')}}`.replace(':id', id),
                type: 'POST',
                data: {'_method': 'DELETE',},
                success: function(data) {
                    if (data.success === true) {
                        cart_data_table.ajax.reload();
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

        function savePurchase() {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to save purchase with selected items?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, Save!",
                cancelButtonText: "No, cancel!",
                customClass: {
                    confirmButton: "btn btn-primary me-3",
                    cancelButton: "btn btn-label-secondary",
                },
            }).then(
                function (t) {
                if(t.value){
                    $.ajax({
                        url: `{{route('purchases.prepare')}}`,
                        type: 'POST',
                        data: {},
                        success: function(data) {
                            if (data.success === true) {
                                cart_data_table.ajax.reload();
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