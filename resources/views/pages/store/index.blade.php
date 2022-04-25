@extends('layouts.admin.app')

@section('title', 'Store')

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
        <button type="button" class="btn-size save-btn" data-toggle="modal"  data-target="#add_store_modal" role="button">Add New Store</button>
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

@include('modal.store.add')
@include('modal.store.update')
@include('modal.store.delete')

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


    $(document).on('click','.store-update', function(){
        var btn = $(this);
        var tr = btn.closest('tr');

        var id = $(this).attr('id');
        var store_code = tr.find("td:nth-child(2)").text();
        var store_name = tr.find("td:nth-child(3)").text();
        $('#edit_store_modal').find('.id-to-update').val(id);
        $('#edit_store_modal').find('#store_code').val(store_code);
        $('#edit_store_modal').find('#store_name').val(store_name);
    })

    $(document).on('click','.store-delete', function(){
        var btn = $(this);
        var tr = btn.closest('tr');

        var id = $(this).attr('id');
        var store_code = tr.find("td:nth-child(2)").text();
        var store_name = tr.find("td:nth-child(3)").text();
        $('#delete_store_modal').find('.id-to-update').val(id);
        $('#delete_store_modal').find('#store_code').val(store_code);
        $('#delete_store_modal').find('#store_name').val(store_name);
    })
    

    $('#store_save').on('click', function(e) {
        e.preventDefault();

        var store_code = $(this).closest('#add_store_modal').find("#store_code").val();
        var store_name = $(this).closest('#add_store_modal').find("#store_name").val();
        var url = "{{ route('store.add') }}";

        $.ajax({
        url:url,
        method:'POST',
        data:{
                    store_code:store_code,
                    store_name: store_name
                },
        success:function(response){
            if(response.success === true) {
            $(this).removeAttr("disabled")
            Swal.fire({
                title: 'Store Inserted',
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

        $('#add_store_modal').modal('hide');

    });

    $('#store_edit').on('click', function(e) {
        e.preventDefault();
        var id = $(this).closest('#edit_store_modal').find(".id-to-update").val();
        var store_code = $(this).closest('#edit_store_modal').find("#store_code").val();
        var store_name = $(this).closest('#edit_store_modal').find("#store_name").val();

        var value = [id, store_code, store_name];

        console.log(value)


        var url = "{{ route('store.edit') }}";

        $.ajax({
        url:url,
        method:'POST',
        data:{
                id: id,
                store_code: store_code,
                store_name: store_name
                },
        success:function(response){
            if(response.success === true) {
            $(this).removeAttr("disabled")
            Swal.fire({
                title: 'Store Updated',
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

        $('#edit_store_modal').modal('hide');
        $(this).removeAttr('disabled');

    });

    $('#store_delete').on('click', function(e) {
        e.preventDefault();

        var id = $(this).closest('#delete_store_modal').find(".id-to-update").val();
        var store_code = $(this).closest('#edit_store_modal').find("#store_code").val();
        var store_name = $(this).closest('#edit_store_modal').find("#store_name").val();
        var url = "{{ route('store.delete') }}";

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
                title: 'Store Deleted',
                text: 'Success',
                icon: 'success',
                confirmButtonText: 'Okay'
            })
            myTable.ajax.reload();
            } else {
            Swal.fire({
                title: 'Error',
                text: respose.message,
                icon: 'error',
                confirmButtonText: 'Okay'
            })
            }
        },
        error:function(error){
            console.log(error)
        }
        });

        $('#delete_store_modal').modal('hide');
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
