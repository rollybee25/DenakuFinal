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
            <div class="col-md-12" id="edit_product">
                <div class="form-group row">
                    <input type="hidden" id="product_id" value="{{$products->id}}" class="form-control"/>
                    <label for="product_code" class="col-md-2 col-form-label">Code</label>
                    <div class="col-md-4">
                        <input type="text" value="{{$products->code}}" class="form-control" id="product_code" autocomplete="off" placeholder="Product Code...">
                    </div>
                    <label for="product_name" class="col-md-2 col-form-label">Name</label>
                    <div class="col-md-4">
                        <input type="text" value="{{$products->name}}" class="form-control" id="product_name" autocomplete="off" placeholder="Product Name...">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="product_category" class="col-md-2 col-form-label">Category</label>
                    <div class="col-md-4">
                        <select id="product_category" class="form-control">
                            <option>Choose Category... {{$products->category}}</option>
                            @foreach ($product_category as $categories)
                                <option 
                                    @if ($products->category == $categories->id) selected @endif  
                                    value="{{ $categories->id }}">{{ $categories->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <label for="product_stocks" class="col-md-2">Stock/s</label>
                    <div class="col-md-4">
                        <input type="text"  value="{{$products->stocks}}" class="form-control" autocomplete="off" id="product_stocks" placeholder="Product Stocks...">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="products_details" class="col-md-2">Details</label>
                    <div class="col-md-10">
                        <textarea class="form-control" autocomplete="off" id="products_details" rows="3">{{$products->details}}</textarea>
                    </div>
                </div>
                <div class="float-right">
                    <button type="button" class="btn-size delete-btn">Close</button>
                    <button type="button" class="btn-size update-btn" id="product_update">Update Product</button>
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

        $('#product_update').on('click', function () {

            
            var form_data = $('#edit_product');
            var product_id =  $('#product_id').val();
            var product_code = form_data.find('#product_code').val();
            var product_name = form_data.find('#product_name').val();
            var product_category = form_data.find('#product_category').val();
            var product_stocks = form_data.find('#product_stocks').val();
            var products_details = form_data.find('#products_details').val();


            var char = [product_id, product_code, product_name, product_category, product_stocks, products_details]
            console.log(char);
            var url = "{{route('product.edit')}}";

            $.ajax({
                url:url,
                method:'POST',
                data:{
                    id: product_id,
                    product_code:product_code,
                    product_name:product_name,
                    product_category:product_category,
                    product_details:products_details,
                    product_stocks:product_stocks,
                },
                success:function(response){
                    if(response.success === true) {
                        $(this).removeAttr("disabled")
                        Swal.fire({
                            title: 'Product Updated',
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

        });
    });
</script>
@endsection