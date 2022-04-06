@extends('layouts.admin.app')

@section('title', 'Products')

<link rel="stylesheet" href="{{ asset('css/main.css') }}">

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <button type="button" class="btn-size save-btn" data-toggle="modal"  data-target="#add_product_modal" role="button">Add New Product</button>
      </div><!-- /.row -->
      @foreach ($products as $product)
          <div class="product-card col-md-3">
              <div class="product-header">
                  <h1>{{ $product->name }}</h1>
                  <span><i class="fas fa-brands fa-times"></i></i></span>
              </div>
              <div class="product-details">
                  <p>{{ $product->details }}</p>
              </div>
              <div class="product-stocks">
                <h2>{{ $product->stocks }}</h2>
                <p>Available Stocks</p>
            </div>
          </div>
      @endforeach
      

      
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

@include('modal.product.add')


@endsection

@section('scripts')
  <script>
      $(document).ready(function(){
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $(document).on('click', '#product_save', function(e){
              e.preventDefault();

              var product = $(this).closest('#add_product_modal');
              var product_code = product.find('#product_code').val();
              var product_name = product.find('#product_name').val();
              var product_category = product.find('#product_category').val();
              var product_details = product.find('#product_details').val();
              var product_stocks = product.find('#product_stocks').val();

              var url = '{{ route('product.add') }}';

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
                    } else {
                        Swal.fire({
                          title: 'Error',
                          text: 'Duplicate Entry for category: '+ product_code,
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