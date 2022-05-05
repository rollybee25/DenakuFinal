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

    .order-list .order-list-btn {
        margin-top: 10px;
    }

    .order-list .order-list-btn {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 5px;
    }
    
    .pos-list {
        padding: 20px;
        grid-area: pos-list;
        border: 2px solid green;
        border-radius: 5px;
    }

    .pos-list .category-list {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 5px;
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
        'header header'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'order-list pos-list'
        'footer footer'
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

    #taena {
        height: 60vh !important;
    }

    .table thead,
    .table th 
    {
        text-align: center;
        font-size: 16px;
    }
    .table td {
        text-align: center;
        vertical-align: middle;
        font-size: 12px;
    }

    .limited_text {
        text-overflow: ellipsis;
    }


    
</style>

@section('content')

<div class="content-wrapper grid-container" style="background-color: white;">
    <div class="header-title gradient-red-bottom">Header</div>
    <div class="order-list">
        <div class="col-md-12 gradient-red">
            <label for="product_category" class="col-md-12 text-center col-form-label">Order</label>
        </div>
        <div class="product_order_list" >
            <div class="table-responsive" id="taena" style="border: 2px solid antiquewhite;">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Code</th>
                        <th scope="col limited_text">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Remove</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    </table>
            </div>
        </div>
        <div class="col-md-12 order-list-btn">
            <div class="send-to-delivery btn btn-info">
                <p>Send to Delivery</p>
            </div>
            <div class="btn btn-info">
                <p>Save as Draft</p>
            </div>
        </div>
    </div>
    <div class="pos-list">
            <div class="form-group row">
                <label for="product_code" class="col-md-3 col-form-label">Client Name: </label>
                <div class="col-md-9">
                    <select id="product_client" class="form-control">
                        <option value = "" selected="">Select Client...</option>
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
                <div class="col-md-12 category-list">
                    @foreach ($product_category as $categories)
                        <div id="{{ $categories->category }}"class="category_select btn btn-info btn-square-md">
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

        var products_list = {};
        var order_list = {};
        var order_id= [];

        var url= "{{route('order.category.load')}}";

        $.ajax({
            url:url,
            method:'get',
            data:{

            },
            success:function(response){
                products_list["category"] = [];
                products_list["products"] = [];


                response.category.forEach(element => {
                    products_list["category"].push(element.category);
                });

                response.products.forEach(product => {
                    products_list["products"].push(product);
                });
            }
        });

        $(document).on('click','.product_select', function() {
            var id = $(this).attr('id');
            var new_value;
            products_list.products.find(product => {
                if(product.id == id && product.stocks > 0){
                    product.stocks = product.stocks - 1;
                    new_value = product.stocks;

                    if( id in order_list ) {
                        order_list[id].stocks += 1;
                    } else {
                        order_list[id] = {
                            id: product.id,
                            code: product.code,
                            name: product.name,
                            stocks: 1,
                        }
                        order_id.push(id);
                    }
                }
            });

            

            $('.product_order_list tbody').empty();

            order_id.forEach((element, index) => {
                var order = order_list[element];
                $('.product_order_list tbody').append($('<tr id="'+order.id+'">')
                    .append($('<td style="vertical-align: middle">').text(index + 1))
                    .append($('<td style="vertical-align: middle">').text(order.code))
                    .append($('<td style="vertical-align: middle">').text(order.name))
                    .append($('<td>')
                        .append($('<span class="order-minus" id="'+order.id+'">').append('<i class="fa fa-minus-square" style="color: #17a2b8; cursor: pointer; font-size: 20px">'))
                        .append($('<input type="text" class="edit-quantity" style="width: 50px; text-align: center; margin: 0 5px 0 5px; border: none">').val(order.stocks))
                        .append($('<span class="order-plus" id="'+order.id+'">').append('<i class="fa fa-plus-square" style="color: green; cursor: pointer; font-size: 20px">'))
                    )
                    .append($('<td style="vertical-align: middle">')
                        .append($('<span class="order-remove" id="'+order.id+'">').append('<i class="fa fa-times-circle fa-3" style="font-size: 20px; color: red; cursor: pointer;">'))
                    )
                );
            });
            
            $(this).find('.product_footer p strong').text(new_value);
        });

        $(document).on('click', '.category_select ', function() {
            var category = $(this).attr("id");


            var new_object = products_list.products.filter(function (el) {
                return el.category == category;
            });

            $('.product_list').empty();
            new_object.forEach(element => {
                $('.product_list').append($('<div id="'+element.id+'" class="product_select btn-square-md grid-items">')
                    .append($('<div class="product_name">')
                        .append($('<p class="text-small">').text(element.name)))
                    .append($('<div class="product_footer">')
                        .append($('<p class="text-big">')
                            .append($('<strong>').text(element.stocks))))
                );
            });
        });

        $(document).on('click', '.order-minus', function() {
            var id = $(this).attr('id');
            var yeah = $('.product_list #'+id+' .product_footer p strong').text();
            order_list[id].stocks -= 1;

            products_list.products.find(product => {
                if(product.id == id) {
                    product.stocks = product.stocks + 1;
                    $('.product_list #'+id+' .product_footer p strong').text(product.stocks);
                }
            })

            var qty = $(this).siblings('input').val();
            if( parseInt(qty) <= 1) {
                $(this).closest('tr').remove();
                order_id = order_id.filter(item => item !== id);
                delete order_list[id];
            } else {
                $(this).siblings('input').val(parseInt(qty - 1));
            }
            console.log(order_id)
        });

        $(document).on('click', '.order-plus', function() {
            var id = $(this).attr('id');


            var stocks = 0;
            products_list.products.find(product => {
                if(product.id == id && product.stocks > 0) {
                    order_list[id].stocks += 1;
                    product.stocks = product.stocks - 1;
                    stocks = product.stocks;
                    $('.product_list #'+id+' .product_footer p strong').text(product.stocks);

                    var qty = parseInt($(this).siblings('input').val());
                    $(this).siblings('input').val(qty + 1);
                }
            })

            
        });

        $(document).on('click', '.order-remove', function() {
            var id = $(this).attr('id');
            var all_qty = parseInt($(this).closest('td').prev().find('input').val());

            products_list.products.find(product => {
                if(product.id == id) {
                    product.stocks = product.stocks + all_qty;
                    $('.product_list #'+id+' .product_footer p strong').text( product.stocks );
                    $(this).closest('tr').remove();
                    order_id = order_id.filter(item => item !== id);
                    delete order_list[id];
                }
            })
        });

        $(document).on('blur', '.edit-quantity', function () {
            var id = $(this).closest('tr').attr('id');
            var qty = parseInt($(this).val());
            var order_qty = order_list[id].stocks;
            var products = products_list.products.find(product => { 
                if( product.id == id ) {
                    return product;
                }
            })

            var total_qty = order_qty + products.stocks;

            if (total_qty >= qty && qty > 0) {
                $('.product_list #'+id+' .product_footer p strong').text(total_qty - qty);
                order_list[id].stocks = qty;
                products_list.products.find(product => { 
                    if( product.id == id ) {
                        product.stocks = total_qty - qty;
                    }
                })
            } else {
                $(this).val(order_qty);
            }
        });

        $(document).on('click', '.send-to-delivery', function() {
            var no_error = 0;
            var error_massage = "<div style='background-color: red; padding: 5px 10px; color:white; margin-bottom: 5px;'> Saving Failed...</div>";
            if( !$('.table tbody')[0].childElementCount > 0 ) {
                error_massage  += "<p style='padding: 0 60px; margin: 0; font-size: 18px; text-align: left'>Empty table: Please select a product</p>";
                no_error = 1;
            }
            if ($('#product_client').val() == '') {
                error_massage  += "<p style='padding: 0 60px; margin: 0; font-size: 18px; text-align: left'>Empty product category</p>";
                $('#product_client').css('border', '1px solid red');
                no_error = 1;
            }

            if(no_error == 0) {
                Swal.fire({
                  title: 'Send to Delivery',
                  text: 'Nice One',
                  icon: 'success',
                  confirmButtonText: 'Okay'
                })
            } else {
                Swal.fire('',error_massage)
            }
        })

        // FOR VALIDATION ONLY
        var number_only = ['.edit-quantity'];
        for_number_only(number_only);
        function for_number_only(array) {
            array.forEach(element => {
            $(document).on('keyup', element, function (e) {
                    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                        this.value = this.value.replace(/[^0-9\.]/g, '');
                    }
                    if (e.which == 13) this.blur();
                });
            });
        }

        
        var change_only = ['#product_client'];
        for_change_only(change_only);
        function for_change_only(array) {
            array.forEach(element => {
                $(document).on('change', element, function (e) {
                    if ($(this).val() == "") {
                        $(this).css('border', '1px solid red');
                    } else {
                        $(this).css('border', '1px solid #ced4da');
                    }
                });
            });
        }

        
    });
</script>
@endsection

