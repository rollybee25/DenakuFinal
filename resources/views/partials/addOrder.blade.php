@extends('layouts.admin.app')

@section('title', 'New Order')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<style>
    /* .btn-square-md {
        text-align: center;
        vertical-align: middle;
    }

    .hundred-px {
        width: 100px;
        height: 100px;
    } */

    .header-title {
        grid-area: header;
    }

    .order-list {
        padding: 20px;
        grid-area: order-list;
        border: 2px solid green;
        border-radius: 5px;
    }
    
    .order-list .gradient-red {
        height: 8%;
    }
    .order-list .product_order_list .table-responsive {
        background-color: #fff;
        height: 92%;
        weight: 100%;
    }

    
    .pos-list {
        padding: 20px;
        grid-area: pos-list;
        border: 2px solid green;
        border-radius: 5px;
    }

    .pos-list .client-input{
        padding: 10px;
        color: white;
        display: grid;
        grid-template-columns: 1fr 2fr;
    }

    .pos-list .client-input div  {
        height: 50px;
        background-color: yellow;
        margin: 5px 5px;
    }

    .pos-list .client-input div label{
        text-align:center;
    }

    .pos-list .product_list  {
        max-height: 320px;
        overflow: auto;
    }

    .pos-list .product_name{
        height: 60px;
    }

    .footer-section {
        grid-area: footer;
        background-color: black;
    }

    .grid-container {
        display: grid;
        grid-template-areas: 'header header'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'footer footer'
        'footer footer';
        grid-template-columns: 1fr 1fr;
        padding: 10px;
        gap: 10px;
    }

    .product_select {
        height: 150px;
    }

    .product_footer span i {
        width: 10px;
        height: 10px;
    }


    
</style>

@section('content')

<div class="content-wrapper grid-container" style="background-color: white;">
    <div class="header-title gradient-red-bottom">Header</div>
    <div class="order-list">
        <div class="col-md-12 gradient-red">
            <label for="product_category" class="col-md-12 text-center col-form-label">Order</label>
        </div>
        <div class="product_order_list">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="pos-list">
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
                <div class="col-md-12 gradient-red">
                    <label for="product_category" class="col-md-12 text-center col-form-label">Category</label>
                </div>
                <div class="col-md-12">
                    @foreach ($product_category as $categories)
                        <div id="{{ $categories->id }}"class="category_select col-md-2 btn btn-info btn-square-md">
                            <p>{{$categories->category}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12 gradient-red">
                    <label for="product_category" class="col-md-12 text-center col-form-label">Product</label>
                </div>
                <div class="product_list display-grid">
                    
                </div>
            </div>
    </div>
    <div class="footer-section">Footer</div>
</div>


{{-- <div class="content-wrapper" style="background-color: white;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="divtable col-md-6">
                    <div class="col-md-12 gradient-red">
                        <label for="product_category" class="col-md-12 text-center col-form-label">Order</label>
                    </div>
                    <div class="order_list display-grid">
                            
                    </div>
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
                        <div class="col-md-12 gradient-red">
                            <label for="product_category" class="col-md-12 text-center col-form-label">Category</label>
                        </div>
                        <div class="col-md-12">
                            @foreach ($product_category as $categories)
                                <div id="{{ $categories->id }}"class="category_select btn btn-info btn-square-md">
                                    <p>{{$categories->category}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 gradient-blue">
                            <label for="product_category" class="col-md-12 text-center col-form-label">Product</label>
                        </div>
                        <div class="product_list display-grid">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

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

        $(document).on('click','.product_select', function() {
            var id = $(this).attr('id');
        });

        $(document).on('click', '.category_select ', function() {
            var category = $(this).attr("id");
            var url = "{{ route('order.category.select') }}"
            $.ajax({
                url:url,
                method:'POST',
                data:{
                    category: category
                },
                success:function(response){
                    $('.product_list').empty();
                    $('.product_list').append(response.products)
                },
                error:function(error){
                    console.log(error)
                }
            });
        });
    });
</script>
@endsection