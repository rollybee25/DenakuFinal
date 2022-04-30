@extends('layouts.admin.app')

@section('title', 'New Order')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<style>
    .btn-square-md {
        width: 100px;
        height: 100px;
        vertical-align: middle;
    }

    .btn-square-md p{
        vertical-align: middle;
    }

    
</style>

@section('content')


<div class="content-wrapper" style="background-color: white;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="divtable col-md-6">
                    <table>
                        <tr>This is Talbe</tr>
                    </table>
                </div>
                <div class="col-md-6" id="add_product">
                    <div class="form-group row">
                        <label for="product_code" class="col-md-3 col-form-label">Client Name: </label>
                        <div class="col-md-9">
                            <select id="product_category" class="form-control">
                                <option selected="">Select Client...</option>
                                @foreach ($client as $clients)
                                    <option value="{{ $clients->id }}">{{ $clients->client_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="product_category" class="col-md-12 text-center col-form-label">Category</label>
                        </div>
                        <div class="col-md-12">
                            @foreach ($product_category as $categories)
                                <div class="category_select btn btn-primary btn-square-md">
                                    <p>{{$categories->category}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
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