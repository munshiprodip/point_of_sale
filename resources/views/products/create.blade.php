@extends('layouts.datatable')
@section('title', 'Add New Product')

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Add New Product</h5>
                    <div class="card-body">
                        <form method="POST" id="add_data_form">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Product name</label>
                                    <input class="form-control" type="text" name="name"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Purchase price</label>
                                    <input class="form-control" type="number" name="purchase_price"/>
                                </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Sale price</label>
                                    <input class="form-control" type="number" name="sale_price"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >UOM</label>
                                    <input class="form-control" type="text" name="uom"/>
                                </div>

                                <div>
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

            let add_data_form = $('#add_data_form');

            add_data_form.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('products.store') }}`,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {      
                            add_data_form.trigger("reset");
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