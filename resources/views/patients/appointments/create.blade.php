@extends('layouts.datatable')
@section('title', 'Create Appointment')

@section('content')
<div class="card">
  <h5 class="card-header">Patient's Information</h5>
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-center h-px-500">
      <form id="create_appointment_form" class="w-px-400 border rounded p-3 p-md-5" method="POST">
        <h3 class="mb-4">Enter to Continue</h3>

        <div class="mb-3">
          <label class="form-label" for="name">Patient's Name</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="john.doe">
        </div>

        <div class="mb-3">
          <label class="form-label" for="phone">Phone Number</label>
          <input type="text" name="phone" id="phone" class="form-control" placeholder="01XX-XXXXXX">
        </div>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary waves-effect waves-light">Continue</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@section('script')
    <script>
        
        let create_appointment_form = $('#create_appointment_form');
        create_appointment_form.on('submit', function(e) {
            let formData = new FormData(this);
            if (!e.isDefaultPrevented()) {
                $.ajax({
                    url: `{{ route('appointments.store') }}`,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if(data.success){
                            window.location.href = `{{ route('appointments.prescribe', ':appointment_no') }}`.replace(':appointment_no', data.appointment_no);
                        }else{
                            Swal.fire({
                                icon: data.type, // "success", "error", "warning", "info", "question"
                                title: data.title,
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: !1,
                            });
                        } 
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
    </script>
@endsection