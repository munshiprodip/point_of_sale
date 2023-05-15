@extends('layouts.datatable')
@section('title', 'Appointments')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>REGISTRATION NO</th>
                        <th>NAME</th>
                        <th>FATHER'S NAME</th>
                        <th>PHONE</th>
                        <th>NID</th>
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
                ajax: "{{ route('patients.list') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "registration_no" },
                    { data: "name" },
                    { data: "father_name" },
                    { data: "phone" },
                    { data: "nid" },
                    { data: (row) => {
                            return `
                                <button class="btn btn-primary btn-sm" onclick="makeAppointment(${row.id})"><i class="ti ti-pencil me-1"></i> Appointment </button>
                            `;
                        } 
                    },
                ],

                columnDefs: [
                    { 
                        'searchable'    : false, 
                        'targets'       : [6] 
                    },
                ],
                pageLength: 10,
                responsive: true,
            });
        });
        
        function makeAppointment(patient_id){
            $.ajax({
                url: `{{ route('appointments.new_appointment') }}`,
                type: "POST",
                data: { patient_id:  patient_id},
                success: function(data) {
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
    </script>
@endsection