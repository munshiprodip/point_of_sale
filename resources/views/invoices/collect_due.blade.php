@extends('layouts.datatable')
@section('title', 'Collect due')

@section('content')
    <div class="row">
        <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Collect Payment</h5>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Invoice ID</td>
                                <td><strong>{{ $invoice->invoice_uid }}</strong></td>
                            </tr>
                            <tr>
                                <td>Invoice ID</td>
                                <td><strong>{{ $invoice->customer_name }}</strong></td>
                            </tr>
                            <tr>
                                <td>Customer Name</td>
                                <td><strong>{{ $invoice->customer_phone }}</strong></td>
                            </tr>
                            <tr>
                                <td>Sub Total</td>
                                <td><strong>{{ $invoice->sub_total }}</strong></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td><strong>{{ $invoice->discount }}</strong></td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td><strong>{{ $invoice->total }}</strong></td>
                            </tr>
                            <tr>
                                <td>Paid Amount</td>
                                <td><strong>{{ $invoice->paid_amount }}</strong></td>
                            </tr>
                            <tr>
                                <td>Current Due</td>
                                <td><strong>{{ $invoice->total - $invoice->paid_amount }}</strong></td>
                            </tr>
                        </table>
                        <form id="collect_due_form">
                            @method('POST')
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label" >Amount</label>
                                    <input class="form-control" type="text" name="paid_amount"  value="{{ $invoice->total - $invoice->paid_amount }}"/>
                                </div>
                                <div>
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}"/>

                                    <button type="submit" class="btn btn-primary me-2">Save</button>
                                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
        </div>
    </div>
@endsection


@section('script')
    <script>

        $(function(){

            let edit_data_form = $('#collect_due_form');

            edit_data_form.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('invoices.make_payment') }}`,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire({
                                icon: data.type, // "success", "error", "warning", "info", "question"
                                title: data.title,
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: !1,
                            });
                            popupCenter({
                                url: `{{ route('invoices.print', $invoice->id) }}`,
                                title: 'Invoice',
                                w: 900,
                                h: 600,
                            });

                            window.location.href = `{{ route("pos") }}`;

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

        });
        
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

















        
    </script>
@endsection