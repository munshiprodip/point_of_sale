@extends('layouts.datatable')
@section('title', 'Invoice List')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>DATE</th>
                        <th>INVOICE NO</th>
                        <th>TOTAL ITEMS</th>
                        <th>AMOUNT</th>
                        <th>STATUS</th>
                        <th>SOLD BY</th>
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
                ajax: "{{ route('invoices.list') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "date" },
                    { data: "invoice_uid" },
                    { data: "items_count" },
                    { data: "total" },
                    { data: "paid_status" },
                    { data: "sold_by" },
                    { data: (row) => {
                            return `
                                <button class="dropdown-item" onclick="openPrintPopUp(':id')"><i class="ti ti-printer me-1"></i></button>
                            `.replace(':id', row.id);
                        } 
                    },
                ],

                columnDefs: [
                    { 
                        'searchable'    : false, 
                        'targets'       : [7] 
                    },
                ],
                dom: '<"row mx-1"<"col-sm-12 col-md-3" l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [
                    {
                    text: "NEW invoice",
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
            window.location.href = `{{ route("pos") }}`;
        }

        function openPrintPopUp(id){
            popupCenter({
                url: `{{ route('invoices.print', ':id') }}`.replace(':id', id),
                title: 'Invoice',
                w: 900,
                h: 600,
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

        
    </script>
@endsection