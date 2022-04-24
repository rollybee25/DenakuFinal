@extends('layouts.admin.app')

@section('title', 'Products')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<style>

    .grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    padding: 10px;
    grid-gap: 10px;
    }


    .product-card {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    min-width: 200px;
    text-align: center;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;
    }

    @media screen and (max-width: 1200px) {
        .grid-container {
                grid-template-columns: 1fr 1fr 1fr;
        }
    }

    @media screen and (max-width: 750px) {
        .grid-container {
                grid-template-columns: 1fr 1fr;
        }
    }

    @media screen and (max-width: 450px) {
        .grid-container {
                grid-template-columns: 1fr;
        }
    }

    
</style>

@section('content')


<div class="content-wrapper" style="background-color: white;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-md-12" id="add_product">
                <div class="form-group row">
                    <label for="product_code" class="col-md-2 col-form-label">Code</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="product_code" autocomplete="off" placeholder="Product Code...">
                    </div>
                    <label for="product_name" class="col-md-2 col-form-label">Name</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="product_name" autocomplete="off" placeholder="Product Name...">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_category" class="col-md-2 col-form-label">Category</label>
                    <div class="col-md-4">
                        <select id="product_category" class="form-control">
                            <option selected="">Choose Category...</option>
                            @foreach ($product_category as $categories)
                                <option value="{{ $categories->id }}">{{ $categories->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="product_stocks" class="col-md-2">Stock/s</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" autocomplete="off" id="product_stocks" placeholder="Product Stocks...">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_details" class="col-md-2">Details</label>
                    <div class="col-md-10">
                        <textarea class="form-control " autocomplete="off" id="product_details" rows="3"></textarea>
                    </div>
                </div>
                <div class="float-right">
                    <button type="button" class="btn-size delete-btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn-size update-btn" id="product_save">Save Product</button>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    //Add some event listener to manipulate CSS

    const wrapper = document.querySelector('.content-wrapper');

    window.addEventListener('resize', function(event){
        wrapper.style.backgroundColor = "#f4f6f9";
    });
    

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.content-wrapper').css("height", "auto");

        $(document).on('click', '#product_save', function(e){
            e.preventDefault();

            var product = $(this).closest('#add_product');
            var product_code = product.find('#product_code').val();
            var product_name = product.find('#product_name').val();
            var product_category = product.find('#product_category').val();
            var product_details = product.find('#product_details').val();
            var product_stocks = product.find('#product_stocks').val();

            var url = "{{ route('product.add') }}";

            $.ajax({
            url:url,
            method:'POST',
            data:{
                product_code:product_code,
                product_name:product_name,
                product_category:product_category,
                product_details:product_details,
                product_stocks:product_stocks,
            },
            success:function(response){
                if(response.success === true) {
                    $(this).removeAttr("disabled")
                    Swal.fire({
                        title: 'Product Inserted',
                        text: 'Success',
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    })
                    window.location.href = "{{route('product.index')}}";
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    })
                }
            },
            error:function(error){
                console.log(error)
            }
            });

            $('#add_product_modal').modal('hide');

        });
    });
</script>
@endsection