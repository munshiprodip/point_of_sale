@extends('layouts.datatable')
@section('title', 'Shop settings')

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Shop Settings</h5>
                    <div class="card-body">
                        <form method="POST" id="shop_setting_form">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Shop name</label>
                                    <input class="form-control" type="text" name="name" value="{{$shop->name}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Shop Address</label>
                                    <input class="form-control" type="text" name="address" value="{{$shop->address}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Website</label>
                                    <input class="form-control" type="text" name="website" value="{{$shop->website}}" />
                                </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Phone Number</label>
                                    <input class="form-control" type="text" name="phone" value="{{$shop->phone}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Email</label>
                                    <input class="form-control" type="text" name="email" value="{{$shop->email}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Header Text</label>
                                    <input class="form-control" type="text" name="header_text" value="{{$shop->header_text}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Footer Text</label>
                                    <input class="form-control" type="text" name="footer_text" value="{{$shop->footer_text}}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >VAT (%)</label>
                                    <input class="form-control" type="number" name="vat" value="{{$shop->vat}}" />
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
            let shop_setting_form = $('#shop_setting_form');

            shop_setting_form.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('shops.update_settings') }}`,
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