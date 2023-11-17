@extends('layouts.datatable')
@section('title', 'Organization Settings')

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Organization Settings</h5>
                    <div class="card-body">
                        <form method="POST" action="{{route('organizations.settings.save')}}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Organization name</label>
                                    <input class="form-control" type="text" name="name" value="{{$organization->name}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Founder</label>
                                    <input class="form-control" type="text" name="founder" value="{{$organization->founder}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Address</label>
                                    <input class="form-control" type="text" name="address" value="{{$organization->address}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Flex time (minutes)</label>
                                    <input class="form-control" type="number" name="flex_time" value="{{$organization->flex_time}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Notification</label>
                                    <select name="notification_status"  class="form-control" >
                                        <option value="0" {{$organization->notification_status==0? "selected" : "" }} >Off</option>
                                        <option value="1" {{$organization->notification_status==1? "selected" : "" }} >On</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Track lunc hour?</label>
                                    <select name="is_track_lunch"  class="form-control" >
                                        <option value="0" {{$organization->is_track_lunch==0? "selected" : "" }} >No</option>
                                        <option value="1" {{$organization->is_track_lunch==1? "selected" : "" }} >Yes</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
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

            let formSecuritySettings = $('#formSecuritySettings');
            formSecuritySettings.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('profiles.security.update') }}`,
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



















        
    </script>
@endsection