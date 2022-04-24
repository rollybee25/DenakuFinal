@extends('layouts.admin.app')

@section('title', 'Product Categories')

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
</style>
@endsection
@section('content')

<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <button type="button" class="btn-size save-btn" data-toggle="modal"  data-target="#add_category_product_modal" role="button">Add New Category</button>
    </div><!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-body">
        <div class="table-responsive">
            <table id="sample_data" class="table table-bordered table-striped" style="width:100%; ">
            <thead>
            <tr>
                <th class="col-md-1">#</th>
                <th class="col-md-2">Code</th>
                <th class="col-md-4">Name</th>
                <th class="col-md-1">Active</th>
                <th class="col-md-3">Action</th>
            </tr>
            </thead>
            <tbody></tbody>
            </table>
        </div>
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

@include('modal.product.category_add')
@include('modal.product.category_update')
@include('modal.product.category_delete')

@endsection


@section('scripts')
<script>

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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

        var url = "{{ route('product-category.active') }}";

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


    $(document).on('click','.category-update', function(){
        var btn = $(this);
        var tr = btn.closest('tr');

        var id = $(this).attr('id');
        var category_name = tr.find("td:nth-child(2)").text();
        $('#edit_category_product_modal').find('.id-to-update').val(id);
        $('#edit_category_product_modal').find('#category_name').val(category_name);
        console.log($('#edit_category_product_modal').find('#category_name').val());
    })

    $(document).on('click','.category-delete', function(){
        var btn = $(this);
        var tr = btn.closest('tr');

        var id = $(this).attr('id');
        var category_name = tr.find("td:nth-child(2)").text();
        $('#delete_category_product_modal').find('.id-to-update').val(id);
        $('#delete_category_product_modal').find('#category_name').val(category_name);
        $('#delete_category_product_modal').find('#category_name').attr('disabled', 'true');s
    })
    

    $('#product_category_save').on('click', function(e) {
        e.preventDefault();

        var category_name = $(this).closest('#add_category_product_modal').find("#category_name").val();
        var url = '{{ route('product-category.add') }}';

        $.ajax({
        url:url,
        method:'POST',
        data:{
                category_name:category_name
                },
        success:function(response){
            if(response.success === true) {
            $(this).removeAttr("disabled")
            Swal.fire({
                title: 'Category Inserted',
                text: 'Success',
                icon: 'success',
                confirmButtonText: 'Okay'
            })
            myTable.ajax.reload();
            } else {
            Swal.fire({
                title: 'Error',
                text: 'Duplicate Entry for category: '+ category_name,
                icon: 'error',
                confirmButtonText: 'Okay'
            })
            }
        },
        error:function(error){
            console.log(error)
        }
        });

        $('#add_category_product_modal').modal('hide');

    });

    $('#product_category_edit').on('click', function(e) {
        e.preventDefault();

        var category_name = $(this).closest('#edit_category_product_modal').find("#category_name").val();
        var id = $(this).closest('#edit_category_product_modal').find(".id-to-update").val();
        var url = '{{ route('product-category.edit') }}';

        $.ajax({
        url:url,
        method:'POST',
        data:{
                category_name:category_name,
                id: id
                },
        success:function(response){
            if(response.success === true) {
            $(this).removeAttr("disabled")
            Swal.fire({
                title: 'Category Updated',
                text: 'Success',
                icon: 'success',
                confirmButtonText: 'Okay'
            })
            myTable.ajax.reload();
            } else {
            Swal.fire({
                title: 'Error',
                text: 'Duplicate Entry for category: '+ category_name,
                icon: 'error',
                confirmButtonText: 'Okay'
            })
            }
        },
        error:function(error){
            console.log(error)
        }
        });

        $('#edit_category_product_modal').modal('hide');
        $(this).removeAttr('disabled');

    });

    $('#product_category_delete').on('click', function(e) {
        e.preventDefault();

        var id = $(this).closest('#delete_category_product_modal').find(".id-to-update").val();
        var url = '{{ route('product-category.delete') }}';

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
                title: 'Category Deleted',
                text: 'Success',
                icon: 'success',
                confirmButtonText: 'Okay'
            })
            myTable.ajax.reload();
            } else {
            Swal.fire({
                title: 'Error',
                text: 'Duplicate Entry for category: '+ category_name,
                icon: 'error',
                confirmButtonText: 'Okay'
            })
            }
        },
        error:function(error){
            console.log(error)
        }
        });

        $('#delete_category_product_modal').modal('hide');
        $(this).removeAttr('disabled');

    });



    var myTable = $('#sample_data').DataTable({ 
            "processing" : true,
            "serverSide" : true,
            "stateSave": true,
            "ajax" : {
                url:"{{ route('store.table') }}",
                type:"POST",
                "data": {
                    _token: "{{csrf_token()}}"
                }
            },
            
            "columns": [
                { 
                    "data": "id",
                    "orderable": false
                },
                { 
                    "data": "code",
                },
                { 
                    "data": "name",
                },
                { 
                    "data": "active",
                    "orderable": false
                },
                { 
                    "data": "action",
                    "orderable": false
                }
            ],
            "columnDefs" : [
                {
                    "targets": 0,
                    'createdCell': function(td, cellData, rowData, row, col) {
                        // $(td).attr('id', cellData);
                    }
                }
            ]
    });

});
</script>
@endsection
