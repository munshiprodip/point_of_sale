@extends('layouts.datatable')
@section('title', 'Edit Product')

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Edit Product</h5>
                    <div class="card-body">
                        <form id="edit_data_form">
                            @method('PATCH')
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Product name</label>
                                    <input class="form-control" type="text" name="name"  value="{{ $product->name }}"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Purchase price</label>
                                    <input class="form-control" type="number" name="purchase_price" value="{{ $product->purchase_price }}"/>
                                </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >Sale price</label>
                                    <input class="form-control" type="number" name="sale_price" value="{{ $product->sale_price }}"/>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" >UOM</label>
                                    <input class="form-control" type="text" name="uom" value="{{ $product->uom }}"/>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary me-2">Update</button>
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

            let edit_data_form = $('#edit_data_form');

            edit_data_form.on('submit', function(e) {
                let formData = new FormData(this);
                if (!e.isDefaultPrevented()) {
                    $.ajax({
                        url: `{{ route('products.update', $product->id) }}`,
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