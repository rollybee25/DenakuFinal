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
        overflow-y: auto;
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
        margin-bottom: 4px;
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

    .order-holder {
        position: relative;
        background-color: white;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }

    .order-list {
        overflow-y: auto;
        margin-bottom: 2vh;
        max-height: 77vh;
        
    }

    .print-order {
        position: absolute;
        bottom: 0;
    }

    .order-list .product-order-item {
        position: relative;
        border-bottom: 1px solid rgba(0, 0, 0, 0.16) ;
        padding: 10px;
        margin: 5px 0;
    }

    .order-list .product-order-item .product-order-close {
        position: absolute;
        color: red;
        cursor: pointer;
        top: 5;
        right: 5;
    }

    .order-list .product-order-item h3 {
        font-size: 22px;
    }

    .order-list .product-order-item .product-order-close i{
        transition: font-size, transform 0.3s;
        transition-timing-function: ease-in-out;
    }
    .order-list .product-order-item .product-order-close i:hover {
        font-size: 20px;
        -webkit-transform:rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    .order-list .product-order-item .product-order-stocks i.add-item {
        color: green;
        cursor: pointer;
    }

    .order-list .product-order-item .product-order-stocks i.minus-item {
        color: blue;
        cursor: pointer;
    }

    .order-list .product-order-item .product-order-stocks span input {
        border: none;
        width: 40px;
        padding: 0 5px;
        margin: 0 10px;
        text-align: center;
    }

    input:focus {
        outline: none !important;
        box-shadow: 0 0 10px #719ECE;
    }
</style>

@section('content')
<div class="content-wrapper">
	<div class="col-md-12 row working-area">
		<div class="col-md-9 product-holder">
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
		<div class="col-md-3 order-holder p-0">
			<div class="order-div">
				<div class="input-group mb-3">
					<select class="custom-select" id="client_select">
						<option value = "" selected="" disabled>Select Client...</option>
                        @foreach ($client as $clients)
                            <option value="{{ $clients->id }}">{{ $clients->client_name }}</option>
                        @endforeach
					</select>
					<div class="input-group-append ">
						<button class="btn btn-secondary btn-outline-secondary" style="color: white" data-toggle="modal"  data-target="#add_client_modal" role="button"><i class="fa-solid fa-pen-to-square"></i></button>
					</div>
				</div>
                <div class="order-list">

                </div>
                <div class="print-order col-md-12">
                    <button type="button" class="btn btn-primary col-md-12 print-receipt-button">Submit</button>
                </div>
			</div>
		</div>
	</div>
</div>

@include('modal.client.add')

@endsection

@section('scripts')
<script src="{{asset('/js/client/client.js')}}"></script>
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

        $(document).on('click', '.product-order-close', function() {
            var form_product = $(this).closest('.product-order-item');
            var product_id = $(this).attr('id');

            form_product.hide("slow", function(){ $(this).remove(); });
            var stocks = order_list.find(x => x.id === product_id).stocks;
            var new_order_list = order_list.filter(x => x.id !== product_id);
            order_list = new_order_list;

            $('.product-item').each(function() {
                if($(this).attr('id') == product_id) {
                    var old_stocks = parseInt($(this).find('.product-item-bottom p strong').text());
                    $(this).find('.product-item-bottom p strong').text(old_stocks + stocks)
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

                        var add_qty = $('#product_id'+product_id).siblings('div').find('span input').val();
                        var new_qty = parseInt(add_qty) + 1;
                        $('#product_id'+product_id).siblings('div').find('span input').val(new_qty);
                    } else {
                        var product = {
                            id: product_id,
                            name: product_name,
                            stocks: 1
                        }
                        order_list.push(product);
                        $('.order-list').append($('<div class="product-order-item">')
                            .append($('<div class="product-order-close" id="'+product_id+'">')
                                .append($('<i class="fa-solid fa-circle-xmark">'))    
                            )
                            .append($('<h3>').text(product_name))
                            .append($('<div class="product-order-stocks">')
                                .append($('<i class="fa-solid fa-square-minus minus-item">'))   
                                .append($('<span>').text('')
                                    .append($('<input class="edit-quantity">').val('1'))    
                                )
                                .append($('<i class="fa-solid fa-square-plus add-item">'))   
                            )
                            .append($('<input type="hidden" class = "product-id" id="product_id'+product_id+'">'))
                        );
                        $('.product-order-item').last().hide().show('slow');
                    }
                    
                } else {
                    var product = {
                        id: product_id,
                        name: product_name,
                        stocks: 1
                    }
                    order_list.push(product);
                    $('.order-list').append($('<div class="product-order-item">')
                        .append($('<div class="product-order-close" id="'+product_id+'">')
                            .append($('<i class="fa-solid fa-circle-xmark">'))    
                        )
                        .append($('<h3>').text(product_name))
                        .append($('<div class="product-order-stocks">')
                            .append($('<i class="fa-solid fa-square-minus minus-item">'))   
                            .append($('<span>').text('')
                                .append($('<input class="edit-quantity">').val('1'))    
                            )
                            .append($('<i class="fa-solid fa-square-plus add-item">'))   
                        )
                        .append($('<input type="hidden" class = "product-id" id="product_id'+product_id+'">'))
                    );
                    $('.product-order-item').last().hide().show('slow');
                }
            }
        })

        $(document).on('click', '.product-order-stocks i.minus-item', function() {
            var value = $(this).closest('.product-order-stocks').find('span input').val();
            var product_id = $(this).closest('.product-order-stocks').siblings('.product-order-close').attr('id');

            var form_product = $(this).closest('.product-order-item');

            var index = order_list.findIndex(x => x.id === product_id);

            if( index > -1) {

                if(order_list[index].stocks > 1){
                    order_list[index].stocks -= 1;
                    $(this).closest('.product-order-stocks').find('span input').val(order_list[index].stocks);
                } else {
                    form_product.remove();
                    var stocks = order_list.find(x => x.id === product_id).stocks;
                    var new_order_list = order_list.filter(x => x.id !== product_id);
                    order_list = new_order_list;
                }
                $('.product-item').each(function() {
                    if($(this).attr('id') == product_id) {
                        var old_stocks = parseInt($(this).find('.product-item-bottom p strong').text());
                        $(this).find('.product-item-bottom p strong').text(old_stocks + 1)
                    }
                })
            }
        })

        $(document).on('click', '.product-order-stocks i.add-item', function() {
            var product_id = $(this).closest('.product-order-stocks').siblings('.product-order-close').attr('id');


            var products_stocks = products_list["products"].find(x => x.id === parseInt(product_id)).stocks;
            var order_stocks = order_list.find(x => x.id === product_id).stocks;

            var check_if_zero = products_stocks - order_stocks;

            if( check_if_zero > 0 ) {

                var index = order_list.findIndex(x => x.id === product_id);
                order_list[index].stocks += 1;
                $(this).closest('.product-order-stocks').find('span input').val(order_list[index].stocks);

                $('.product-item').each(function() {
                    if($(this).attr('id') == product_id) {
                        var old_stocks = parseInt($(this).find('.product-item-bottom p strong').text());
                        $(this).find('.product-item-bottom p strong').text(check_if_zero - 1)
                    }
                })
            }
        });

        // $('.edit-quantity').bind('input propertychange', function() {
        //     $(this).trigger('blur');
        // })

        $(document).on('blur', '.edit-quantity', function() {
            var product_id = $(this).closest('.product-order-stocks').siblings('.product-order-close').attr('id');

            var products_stocks = products_list["products"].find(x => x.id === parseInt(product_id)).stocks;
            var order_stocks = order_list.find(x => x.id === product_id).stocks;
            var index = order_list.findIndex(x => x.id === product_id);


            if($(this).val() == "" || $(this).val() == '0') {
                $(this).val(order_stocks);
            }

            var input_stocks = parseInt($(this).val());
            var count_if_possible = products_stocks-input_stocks;

            if(count_if_possible >= 0) {
                order_list[index].stocks = input_stocks;

                $('.product-item').each(function() {
                    if($(this).attr('id') == product_id) {
                        var old_stocks = parseInt($(this).find('.product-item-bottom p strong').text());
                        $(this).find('.product-item-bottom p strong').text(count_if_possible)
                    }
                })

            } else {
                $(this).val(order_stocks);
            }
        })

        $('#client_save').on('click', function(e) {
          e.preventDefault();

          var client_name = $(this).closest('#add_client_modal').find("#client_name").val();
          var client_phone = $(this).closest('#add_client_modal').find("#client_phone").val();
          var client_address = $(this).closest('#add_client_modal').find("#client_address").val();


          var char = [client_name, client_phone, client_address];
          
          alert(char);

          var url = "{{ route('client.add') }}";

          $.ajax({
            url:url,
            method:'POST',
            data:{
                    client_name:client_name,
                    client_phone: client_phone,
                    client_address: client_address
                    },
            success:function(response){
                if(response.success === true) {
                Swal.fire({
                    title: 'Client Inserted',
                    text: 'Success',
                    icon: 'success',
                    confirmButtonText: 'Okay'
                })
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
            $(this).removeAttr("disabled")
            $('#add_client_modal').modal('hide');

        });

        $(document).on('click', '.print-receipt-button', function() {

                if( $('#client_select option:selected').val() == "" )
                    return alert('Select Customer');
                if( order_list.length <= 0 )
                    return alert("Select product");
                

                var url = "{{ route('pos.add') }}";
                var orders = JSON.stringify(order_list);
                var client_id = $('#client_select option:selected').val();

                Swal.fire({
                        title: 'Proceed to delivery?',
                        text: "You can edit it later, thanks",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:url,
                            method:'post',
                            data:{
                                client_id: client_id,
                                orders: orders
                            },
                            success:function(response){
                                if( response.success == true ) {
                                    Swal.fire({
                                        title: 'Order Successful',
                                        text: 'Order item added to Order List',
                                        icon: 'success',
                                        confirmButtonText: 'Okay'
                                    });

                                    $('.product-order-item').each( function() {
                                        $(this).remove();
                                    });
                                    $('#client_select').val("");
                                }
                            }
                        });
                    }
                })

                
                
                // var url = "{{ route('pdf.test') }}";

                // window.open(url);

                //     $.ajax({
                //     url:url,
                //     method:'get',
                //     data:{},
                //     xhrFields: {
                //         responseType: 'blob'
                //     },
                //     success:function(response, status, xhr){
                //         var filename = "";                   
                //         var disposition = xhr.getResponseHeader('Content-Disposition');

                //         if (disposition) {
                //             var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                //             var matches = filenameRegex.exec(disposition);
                //             if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                //         } 
                //         var linkelem = document.createElement('a');
                //         try {

                //             var blob = new Blob([response], { type: 'application/octet-stream' });                        

                //             if (typeof window.navigator.msSaveBlob !== 'undefined') {
                //                 //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                //                 window.navigator.msSaveBlob(blob, filename);
                //             } else {
                //                 var URL = window.URL || window.webkitURL;
                //                 var downloadUrl = URL.createObjectURL(blob);

                //                 if (filename) { 
                //                     // use HTML5 a[download] attribute to specify filename
                //                     var a = document.createElement("a");

                //                     // safari doesn't support this yet
                //                     if (typeof a.download === 'undefined') {
                //                         window.location = downloadUrl;
                //                     } else {
                //                         a.href = downloadUrl;
                //                         a.download = filename;
                //                         document.body.appendChild(a);
                //                         a.target = "_blank";
                //                         a.click();
                //                     }
                //                 } else {
                //                     window.location = downloadUrl;
                //                 }
                //             }   

                //         } catch (ex) {
                //             console.log(ex);
                //         } 
                //     }
                // })
        })


        var philippines = [];

        $.ajax({
            url:"{{ route('philippines') }}",
            method:'GET',
            success:function(response){

              // const region_1 = response["philippines"]["01"].filter( region => region.region_name === "REGION 1")

              var region = "01"
              var province = "ILOCOS NORTE";
              var municipality = "PAOAY";
              var barangay = "";

              // barangay_list = response["philippines"][region]["province_list"][province]["municipality_list"][municipality]["barangay_list"];

              philippines = response.philippines;

              var client_region = $('#client_region');

              client_region.append($('<option>', {
                  value: null,
                  text: 'Select region'
              }));


              var list_name = ['REGION I', 'REGION II', 'REGION III', 'REGION IV-A', 'REGION IV-B', 'REGION IX', 'REGION V', 'REGION VI', 'REGION VII', 'REGION VIII', 'REGION X', 'REGION XI', 'REGION XII', 'REGION XIII','NCR', 'CAR', 'BARMM']
              var object = ['01', '02', '03', '4A', '4B', '09', '05', '06', '07', '08', '10', '11', '12', '13', 'NCR', 'CAR', 'BARMM'];

              object.forEach((value, index) => {
                client_region.append($('<option>', {
                    value: value,
                    text: list_name[index]
                }));
              });

            },
        })

        $("#client_region").change(function() {
            var selected_region = $('#client_region').find(":selected").val();
            var client_province = $('#client_province');

            client_province.empty();
            client_province.append($('<option>', {
                value: null,
                text: 'Select Province'
            }));

            for ( province in  philippines[selected_region].province_list ) {
              client_province.append($('<option>', {
                  value: province,
                  text: province
              }));
            }
        })

        $("#client_province").change(function() {
            var selected_region = $('#client_region').find(":selected").val();
            var selected_province = $('#client_province').find(":selected").val();
            var client_municipality = $('#client_municipality');
            

            client_municipality.empty();
            client_municipality.append($('<option>', {
                value: null,
                text: 'Select Municipality'
            }));

            // console.log(philippines[selected_region].province_list[selected_province])


            for ( municipality in  philippines[selected_region].province_list[selected_province].municipality_list ) {
              client_municipality.append($('<option>', {
                  value: municipality,
                  text: municipality
              }));

            }
        })

        $("#client_municipality").change(function() {
            var selected_region = $('#client_region').find(":selected").val();
            var selected_province = $('#client_province').find(":selected").val();
            var client_municipality = $('#client_municipality').find(":selected").val();
            var client_barangay = $('#client_barangay');

            client_barangay.empty();
            client_barangay.append($('<option>', {
                value: null,
                text: 'Select Barangay'
            }));

            var barangay_list = philippines[selected_region].province_list[selected_province].municipality_list[client_municipality].barangay_list

            for ( barangay in barangay_list ) {
              client_barangay.append($('<option>', {
                  value: barangay,
                  text: barangay_list[barangay]
              }));

            }
        })


        // FOR VALIDATION ONLY
        var number_only = ['.edit-quantity'];
        for_number_only(number_only);
        function for_number_only(array) {
            array.forEach(element => {
            $(document).on('keyup', element, function (e) {
                    if (this.value != this.value.replace(/[^0-9]/, '')) {
                            this.value = this.value.replace(/[^0-9]/, '');
                    }
                    if((this.value+'').match(/^0/)) {
						this.value = (this.value+'').replace(/^0+/g, '');
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

