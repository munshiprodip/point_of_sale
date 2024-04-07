@extends('layouts.datatable')
@section('title', 'Create Invoice')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <!-- <h5 class="card-header">Select Product</h5> -->
                <div class="card-body">
                    <form id="select_product_form">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label" >Product name</label>
                                <select name="product_id" class="form-select select3 " id="product_id" required >
                                    <option value="">Select product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->sku }} - {{ $product->name }} - {{ $product->sale_price }} TK - Stock {{ $product->stockQty(auth()->user()->shop_id)}} {{ $product->uom}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label" >Quantity</label>
                                <input class="form-control" type="number" id="quantity" name="quantity" value="1"/>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary me-2 w-100">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card ">
                <!-- <h5 class="card-header">Customer Info</h5> -->
                <div class="card-body">
                    <form id="create_invoice_form">
                        <div class="row">
                            <div class="mb-3 col-md-8">
                                <label class="form-label" >Customer Name</label>
                                <input class="form-control" type="text" name="customer_name"/>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Customer Phone</label>
                                <input class="form-control" type="text" name="customer_phone"/>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Sub Total</label>
                                <input class="form-control" type="number" id="sub_total" name="sub_total" value="0" readonly/>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Discount</label>
                                <input class="form-control" type="number" name="discount" id="discount" value="0"/>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Net Receivable</label>
                                <input class="form-control" type="number" name="grand_total" id="grand_total" value="0" readonly/>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Cash Given</label>
                                <input class="form-control" type="number" name="cash_given" id="cash_given" value="0" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Return</label>
                                <input class="form-control" type="number" name="return_amount" id="return_amount" value="0" readonly/>
                            </div>
                            <div class="mt-4 col-md-4">
                                <button type="submit" class="btn btn-success me-2 w-100">INVOICE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4 h-100">
                <h5 class="card-header">Cart</h5>
                <div class="card-body">
                    <table class="table" id="cart_data_table">
                        <thead>
                            <tr>
                                <td>SL</td>
                                <td>PRODUCT NAME</td>
                                <td>UNIT PRICE</td>
                                <td>QUANTITY</td>
                                <td>TOTAL</td>
                                <td>#</td>
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

        let cart_data_table     = $("#cart_data_table");
        let select_product_form = $('#select_product_form');
        let create_invoice_form = $('#create_invoice_form');

        $(function(){
            select_product_form.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('invoices.add_to_cart') }}`,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {      
                            select_product_form.trigger("reset");
                            $('#product_id').trigger( "change" );
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

            create_invoice_form.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('invoices.prepare') }}`,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {      
                            create_invoice_form.trigger("reset");
                            cart_data_table.ajax.reload();
                            Swal.fire({
                                icon: data.type, // "success", "error", "warning", "info", "question"
                                title: data.title,
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: !1,
                            });

                            popupCenter({
                                url: `{{ route('invoices.print', ':id') }}`.replace(':id', data.invoice_id ),
                                title: 'Invoice',
                                w: 900,
                                h: 600,
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
                ajax: "{{ route('pos') }}",
                searching: false, 
                ordering: false, 
                paging: false, 
                info: false, 
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
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
                pageLength: 200,
                responsive: true,
                footerCallback: function (row, data, start, end, display) {
                    let api = this.api();

                    // Remove the formatting to get the integer data for summation
                    let intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    let total = api
                        .column(4, { search: 'applied' })
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Update footer
                    // $(api.column(4).footer()).html(total + '.00');
                    $('#sub_total').val(total);
                    updateCalculation();
                }
            });
            
            $("#product_id").on('change', function(){
                $("#quantity").focus();
            })
        });

        $('#discount').on('keyup', updateCalculation);
        $('#cash_given').on('keyup', updateCalculation);

        function updateCalculation(){
            let sub_total = $('#sub_total').val();
            let discount = $('#discount').val();

            $('#grand_total').val(sub_total-discount);

            let grand_total = $('#grand_total').val();
            let cash_given = $('#cash_given').val();
            if(cash_given>0){
                $('#return_amount').val(cash_given-grand_total);
            }
        }



        function deletFromCart(id) {
            $.ajax({
                url: `{{route('invoices.delete_from_cart', ':id')}}`.replace(':id', id),
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


        const popupCenter = ({ url, title, w, h }) => {
            const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
            const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;
            const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                .documentElement.clientWidth : screen.width;
            const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;
            const systemZoom = width / window.screen.availWidth;
            const left = (width - w) / 2 / systemZoom + dualScreenLeft
            const top = (height - h) / 2 / systemZoom + dualScreenTop
            const newWindow = window.open(url, title,
                `
            scrollbars=yes,
            width=${w / systemZoom},
            height=${h / systemZoom},
            top=${top},
            left=${left}
            `
            )
            if (window.focus) newWindow.focus();
        }

        // function savePurchase() {
        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "You want to save purchase with selected items?",
        //         icon: "warning",
        //         showCancelButton: !0,
        //         confirmButtonText: "Yes, Save!",
        //         cancelButtonText: "No, cancel!",
        //         customClass: {
        //             confirmButton: "btn btn-primary me-3",
        //             cancelButton: "btn btn-label-secondary",
        //         },
        //     }).then(
        //         function (t) {
        //         if(t.value){
        //             $.ajax({
        //                 url: `{{route('invoices.prepare')}}`,
        //                 type: 'POST',
        //                 data: {},
        //                 success: function(data) {
        //                     if (data.success === true) {
        //                         cart_data_table.ajax.reload();
        //                     } 

        //                     Swal.fire({
        //                         icon: data.type, // "success", "error", "warning", "info", "question"
        //                         title: data.title,
        //                         text: data.message,
        //                         timer: 1500,
        //                         showConfirmButton: !1,
        //                     });


        //                 },
        //                 error: function() {
        //                     Swal.fire({
        //                         icon: 'warning', // "success", "error", "warning", "info", "question"
        //                         title: "Warning!",
        //                         text: 'Oops, something went wrong. Please try again.',
        //                         timer: 1500,
        //                         showConfirmButton: !1,
        //                     });
        //                 }
        //             });
        //         }
        //     });
        // }

        
    </script>
@endsection