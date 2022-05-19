@extends('layouts.admin.app')

@section('title', 'New Order')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
<style>

    .working-area {
        width: 100%;
        height: 100%;
    }
    .product-div {
		margin-left: 20px;
		margin-right: 10px;
	}

    .product-div .search-box div {
        position: relative;
    }

	.product-div .search-box div input {
		width: 520px;
		border-radius: 0px;
		height: 7vh;
	}

    .category-list{
        margin-top: 2vh;
        height: 10vh;
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .category-list:hover{
        overflow-x: auto;
    }

    .category-list::-webkit-scrollbar {
        height: 10px;
    }

    .category-list::-webkit-scrollbar-track{
        background-color: transparent;
    }

    .category-list::-webkit-scrollbar-thumb {
        background-color: white;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    .category-item {
        display: inline-block;
        padding: 5px 10px;
        margin-right: 7px;
        border-radius: 3px;
        width: 20%;
        cursor: pointer;
        background-color: white;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
        transition: background-color 500ms;
        transition-timing-function: linear;
    }

    .category-item img{
        vertical-align:middle;
        display: inline-block;
        padding-right: 2px;
        cursor: pointer;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    }

    .category-item span{
        padding-left: 5px;
        vertical-align:middle;
        display: inline-block;
        text-align: right;
        cursor: pointer;
    }

    .category-item i{
        font-size: 30px;
        vertical-align:middle;
        color: white;
        padding: 5px;
        background-color: #EAEDED;
        border-radius: 5px;
    }


    .category-item:hover{
        color: white;
        background-color: #007bff;
    }

    .category-item.active{
        background-color: #007bff;
        color: white;
    }

    .category-item.active i{
        color: white;
        background-color: #007bff;
    }


    .category-item input {
        height: 7vh;
        border-radius: 0px;
    }

    .product-holder, .order-holder {   
        height: 100%;
        padding-top: 4vh;
    }

	.order-div{
        width: 100%;
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 4vh;
	}

    .order-div div {
		margin: 0;
	}

	.order-div div select {
		height: 7vh;
	}

    .order-div .print-order{
        padding: 0;
    }

    .order-holder {
        position: relative;
        background-color: white;
    }
</style>

@section('content')
<div class="content-wrapper">
	<div class="col-md-12 row working-area">
		<div class="col-md-8 product-holder">
			<div class="product-div">
				<div class="search-box">
					<div>
                        <input class="form-control" type="text" placeholder="Search for product here..."/>
                        <div><i ></i></div>
                    </div>
				</div>
                <div class="category-list">
					<div id="" class="category-item active"><i class="fa fa-th-list" aria-hidden="true"></i><span>All Category</span></div>
                    @foreach ($product_category as $category)
                        <div id="{{$category->id}}" class="category-item"><img src="{{asset('images/'.$category->images)}}" width="40" height="40" class="img-rounded" alt=""/><span>{{$category->category}}</span></div>
                    @endforeach
				</div>
			</div>
		</div>
		<div class="col-md-4 order-holder p-0">
			<div class="order-div">
				<div class="input-group mb-3">
					<select class="custom-select" id="inputGroupSelect02">
						<option value = "" selected="">Select Client...</option>
                        @foreach ($client as $clients)
                            <option value="{{ $clients->id }}">{{ $clients->client_name }}</option>
                        @endforeach
					</select>
					<div class="input-group-append ">
						<button class="btn btn-secondary btn-outline-secondary" style="color: white" type="button"><i class="fa-solid fa-pen-to-square"></i></button>
					</div>
				</div>
                
                <div class="print-order col-md-12">
                    <button type="button" class="btn btn-primary col-md-12">Print Receipt</button>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>

    //Add some event listener to manipulate CSS

	$('.main-header').hide();

    var element = document.getElementsByClassName('category-list');

    element[0].scrollIntoView(); // Scroll to this element

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

        $('.pushmenu-btn').trigger('click');

        $('.category-item').click(function() {
            $('.category-item').each(function() {
                if($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });
            $(this).addClass('active');
        });

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

