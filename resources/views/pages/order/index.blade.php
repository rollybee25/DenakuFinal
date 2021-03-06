@extends('layouts.admin.app')

@section('title', 'Products')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@section('stylesheets')
	<style>
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
		.box{
			box-sizing: border-box;
			border: 3px solid transparent;
			background-clip:padding-box;
			box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
		}

		div.product-stocks {
			position: absolute;
			bottom: 10px;
		}

		.delete-product {
			position: absolute;
			right: 0;
			margin-right: 5px;
			margin-top: 10px;
		}

		.button-top {
			margin-top: 10px;
		}
	</style>
@endsection

@section('content')

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2 col-md-12 row">
			{{-- <a href="{{ route('product.add-view') }}" class="btn-size save-btn add-new-product col-md-2" >Add New Product</a> --}}
			{{-- <div class="btn-group offset-md-8 col-md-2" role="group" aria-label="Basic example">
				<button id="table_view_btn" type="button" class="btn view-button btn-size btn-secondary"><i class="fa-solid fa-table-list"></i></button>
				<button id="table_grid_btn" type="button" class="btn view-button btn-size btn-secondary"><i class="fa-solid fa-table"></i></button>
			</div> --}}
		</div><!-- /.row -->



		<div class="table-responsive-sm divProductTable">
			<table id="productTable" class="table" width="100%">
				<thead>
				<tr>
					<th>Product Code</th>
					<th>Product Name</th>
					<th>Category</th>
					<th>Available Stocks</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			
			</table>
		</div>



		<div class="product-grid-view">
		<div class="grid-container row g-2" id="hide_div">
			@foreach ($products as $product)
			<div class="product-card col-md-3 mt-2 box" style="height: 250px">
				<div class="button-top">
				<label  class="switch">
					<input type="checkbox" checked/>
					<span class="slider round"></span>
				</label>
				<a href="#"><i class="fa fa-trash delete-product fa-lg float-sm-right" aria-hidden="true" x></i></a>
				</div>
				<div class="product-header text-center mt-5">
					<h1>{{ $product->name }}</h1>
				</div>
				<div class="product-stocks">
				<p class = "float-left">Available Stocks: <strong>{{ $product->stocks }}</strong></p>
				</div>
			</div>
			@endforeach
		</div>
		</div>
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
<div class="container-fluid">
	
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@include('modal.product.delete');
@endsection


@section('scripts')

<script src="{{asset('/js/product/product-local-storage.js')}}"></script>
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

		$('#hide_div').hide();

		var product_json_view = localStorage.getItem('view_button');

		if(product_json_view) {
			if(product_json_view == 'table_view_btn') {
				$('.divProductTable').show();
				$('#hide_div').hide();
			} else {
				$('.divProductTable').hide();
				$('#hide_div').show();
			}
			$('#'+product_json_view).addClass('active');
		} else {
			window.localStorage.setItem('view_button', 'table_view_btn');
			$('#table_view_btn').addClass('active');
		}
		

		$('#table_view_btn').on('click', function() {
			if($(this).hasClass('active') !== true ) {
				$(this).addClass('active');
			}
			$('#table_grid_btn').removeClass('active');
			$('.divProductTable').show();
			$('#hide_div').hide();
		});

		$('#table_grid_btn').on('click', function() {
			if($(this).hasClass('active') !== true ) {
				$(this).addClass('active');
			}
			$('#table_view_btn').removeClass('active');
			$('.divProductTable').hide();
			$('#hide_div').show();
		});


		$(document).on('click', '.checked-box', function(){
			var value = $(this).is(':checked');
			var id = $(this).attr('id');
			var active;


			if(value === true) {
				active = 1;
			} else {
				active = 0;
			}

			console.log(active);

			var url = "{{ route('product.active') }}";

			$.ajax({
			url:url,
			method:'POST',
			data:{
					id: id,
					active: active
				},
			success:function(response){
				// do nothing
			},
			error:function(error){
				console.log(error)
			}
			});

        })



		$(document).on('click', '.product-update', function() {
			var id = $(this).attr('id');
			var url = '{{ route("product.edit-view", ":id") }}';
			url = url.replace(':id', id);
			window.location.href = url;
		});

		$(document).on('click', '.product-delete', function() {
			var btn = $(this);
            var tr = btn.closest('tr');

            var id = $(this).attr('id');
            var product_code = tr.find("td:nth-child(1)").text();
			var product_name = tr.find("td:nth-child(2)").text();
            $('#delete_product_modal').find('.id-to-update').val(id);
            $('#delete_product_modal').find('#product_code').val(product_code);
			$('#delete_product_modal').find('#product_name').val(product_name);
		});

		$('#product_delete_modal').click(function(e) {
			e.preventDefault();

			var id = $(this).closest('#delete_product_modal').find(".id-to-update").val();
			var url = "{{ route('product.delete') }}";

			$.ajax({
			url:url,
			method:'POST',
			data:{
					id: id
					},
			success:function(response){
				if(response.success === true) {
				$(this).removeAttr("disabled")
				Swal.fire({
					title: 'Product Deleted',
					text: 'Success',
					icon: 'success',
					confirmButtonText: 'Okay'
				})
				myTable.ajax.reload();
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

			$('#delete_product_modal').modal('hide');
			$(this).removeAttr('disabled');



		});

		




		var myTable = $('#productTable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": "/product-get-table-data",
				"dataType": "json",
				"type": "POST",
			},
			"order": [
                [0, "asc"]
            ],
			"columns": [
                { 
                    "data": "code",
                },
				{ 
                    "data": "name",
                    "orderable": false
                },
				{ 
                    "data": "category",
                    "orderable": false
                },
				{ 
                    "data": "stocks",
                    "orderable": false
                },
				{ 
                    "data": "status",
                    "orderable": false
                },
				{ 
                    "data": "action",
                    "orderable": false
                }
			]
		});
	});

</script>
@endsection