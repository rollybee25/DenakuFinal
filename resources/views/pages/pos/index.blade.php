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
        font-size: 14px;
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

    .product-holder, .order-holder {   
        height: 100%;
        padding-top: 4vh;
    }

    .product-list {
        height: 75vh;
        width: 100%;
        max-height: 75vh;
    }

    .product-list .product-item{
        display: inline-block;
        background-color: white;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
        border-radius: 2px;
        width: 150px;
        height: 150px;
        padding: 10px;
        margin-right: 4px;
        cursor: pointer;
        transition: background-color 150ms;
        transition-timing-function: linear;
    }

    .product-list .product-item .product-photo {
        width: 100%;
        height: 100px;
        background-color: #ccc;
        margin: 0 auto;
        cursor: pointer
    }

    .product-list .product-item:hover{
        color: white;
        background-color: #00b6b0;
    }

    .product-list .product-item .product-item-bottom{
        width: 100%;
        cursor: pointer
    }

    .product-list .product-item .product-item-bottom h3{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        font-size: 14px;
        margin: 0;
        cursor: pointer
    }

    .product-list .product-item .product-item-bottom p{
        margin: 0;
        color: #00b6b0;
        font-size: 14px;
        cursor: pointer
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
                <div class="product-list">
                    @foreach ($products as $product)
                        <div class="product-item" id="{{ $product->id }}" title="{{ $product->name }}">
                            <div class="product-photo"></div>
                            <div class="product-item-bottom" >
                                <h3>{{ $product->name }}</h3>
                                <p>Stock/s: <strong>{{ $product->stocks }}</strong></p>
                                <input type="hidden" name="category" id="category_select" value="{{ $product->category }}">
                            </div>
                        </div>
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
                <div class="order-list">

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
        var order_list = [];
        var category_select = '';

        $('.pushmenu-btn').trigger('click');

        $('.category-item').click(function() {
            category_select = $(this).find('span').text();
            $('.category-item').each(function() {
                if($(this).hasClass('active')) {
                    $(this).removeClass('active');
                }
            });
            $(this).addClass('active');

            if(category_select != 'All Category') {
                $('.product-item .product-item-bottom #category_select').each(function() {
                    var product_item = $(this).val();
                    if(product_item.includes(category_select)) {
                        $(this).closest('.product-item').show('slow');
                    } else {
                        $(this).closest('.product-item').hide('slow');
                    }
                })
            } else {
                $('.product-item').each(function() {
                    $(this).show('slow');
                });
            }
            

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

        $(document).on('keyup', '.search-box div input', function() {
            var search = $('.search-box div input').val().toUpperCase();
            $('.product-item .product-item-bottom h3').each(function() {
                var product_item = $(this).text().toUpperCase();
                if(product_item.includes(search)) {
                    $(this).closest('.product-item').show('slow');
                } else {
                    $(this).closest('.product-item').hide('slow');
                }
            })
        })

        $(document).on('click','.product-item', function() {
            var product = $(this);
            var product_id = product.attr('id');
            var product_name = product.find('.product-item-bottom h3').text();
            var stocks = parseInt(product.find('.product-item-bottom p strong').text());

            if(stocks > 0) {
                stocks -= 1;
                product.find('.product-item-bottom p strong').text(stocks);

                if(order_list.length > 0){

                    var index = order_list.findIndex(x => x.id === product_id);
                    
                    if (index > -1) {
                        order_list[index].stocks += 1;
                        var add_qty = $('.order-list .product-order-item p span').text();
                        var new_qty = parseInt(add_qty) + 1;

                        var add_qty = $('#product_id'+product_id).siblings('p').find('span').text();
                        var new_qty = parseInt(add_qty) + 1;
                        $('#product_id'+product_id).siblings('p').find('span').text(new_qty);
                    } else {
                        var product = {
                            id: product_id,
                            name: product_name,
                            stocks: 1
                        }
                        order_list.push(product);
                        $('.order-list').append($('<div class="product-order-item">')
                            .append($('<h3>').text(product_name))
                            .append($('<p>').text('x')
                                .append($('<span>').text(1))
                            )
                            .append($('<input type="hidden" class = "product-id" id="product_id'+product_id+'">'))
                        );
                    }
                    
                } else {
                    var product = {
                        id: product_id,
                        name: product_name,
                        stocks: 1
                    }
                    order_list.push(product);
                    $('.order-list').append($('<div class="product-order-item">')
                        .append($('<h3>').text(product_name))
                        .append($('<p>').text('x')
                            .append($('<span>').text(1))
                        )
                        .append($('<input type="hidden" class = "product-id" id="product_id'+product_id+'">'))
                    );
                }
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

        $(document).on('mouseover', '.product-item', function() {
            var stocks = $(this).find('.product-item-bottom p');
            stocks.css("color", "white");
        })

        $(document).on('mouseleave', '.product-item', function() {
            var stocks = $(this).find('.product-item-bottom p');
            stocks.css("color", "#00b6b0");
        })

        
    });
</script>
@endsection

