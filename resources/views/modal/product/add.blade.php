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

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <button type="button" class="btn-size save-btn" data-toggle="modal"  data-target="#add_product_modal" role="button">Add New Product</button>
      </div><!-- /.row -->

      <div class="grid-container">
            @foreach ($products as $product)
            <div class="product-card">
                <div class="product-header">
                    <h1>{{ $product->name }}</h1>
                </div>
                <div class="product-stocks">
                  <h2>{{ $product->stocks }}</h2>
                  <p>Available Stocks</p>
                </div>
                <div class="product-details">
                  <p>{{ $product->details }}</p>
                </div>
            </div>
          @endforeach
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