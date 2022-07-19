@extends('layouts.admin.app')

@section('title', 'Clients')

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
        <button type="button" class="btn-size save-btn" data-toggle="modal"  data-target="#add_client_modal" role="button">Add New Client</button>
      </div><!-- /.row -->
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="table-responsive">
            <table id="sample_data" class="table table-bordered table-striped" style="width:100%; ">
            <thead>
              <tr>
                <th class="col-md-1">#</th>
                <th class="col-md-2">Full Name</th>
                <th class="col-md-1">Phone</th>
                <th class="col-md-3">Address</th>
                <th class="col-md-1">Active</th>
                <th class="col-md-2">Action</th>
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

@include('modal.client.add')
@include('modal.client.update')
@include('modal.client.delete')

@endsection


@section('scripts')
  <script>
    
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        



        $(document).on('click', '.checked-box', function(){
          var value = $(this).is(':checked');
          var id = $(this).attr('id');
          var active;


          if(value === true) {
            active = 1;
          } else {
            active = 0;
          }

          var url = "{{ route('client.active') }}";

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


        $(document).on('click','.client-update', function(){
            var btn = $(this);
            var tr = btn.closest('tr');

            var id = $(this).attr('id');
            var client_name = tr.find("td:nth-child(2)").text();
            var client_phone = tr.find("td:nth-child(3)").text();
            var client_address = tr.find("td:nth-child(4)").text();

            $('#edit_client_modal').find('.id-to-update').val(id);
            $('#edit_client_modal').find('#client_name').val(client_name);
            $('#edit_client_modal').find('#client_phone').val(client_phone);
            $('#edit_client_modal').find('#client_address').val(client_address);
        })

        $(document).on('click','.client-delete', function(){
            var btn = $(this);
            var tr = btn.closest('tr');

            var id = $(this).attr('id');
            var client_name = tr.find("td:nth-child(2)").text();
            var client_phone = tr.find("td:nth-child(3)").text();
            var client_address = tr.find("td:nth-child(4)").text();

            $('#delete_client_modal').find('.id-to-update').val(id);
            $('#delete_client_modal').find('#client_name').val(client_name);
            $('#delete_client_modal').find('#client_phone').val(client_phone);
            $('#delete_client_modal').find('#client_address').val(client_address);
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
          $(this).removeAttr("disabled")
          $('#add_client_modal').modal('hide');

        });

        $('#client_edit').on('click', function(e) {
          e.preventDefault();
            
          var id = $(this).closest('#edit_client_modal').find(".id-to-update").val();
          var client_name = $(this).closest('#edit_client_modal').find("#client_name").val();
          var client_phone = $(this).closest('#edit_client_modal').find("#client_phone").val();
          var client_address = $(this).closest('#edit_client_modal').find("#client_address").val();

          var url = "{{ route('client.edit') }}";

          $.ajax({
            url:url,
            method:'POST',
            data:{
                    id: id,
                    client_name: client_name,
                    client_phone: client_phone,
                    client_address: client_address,
                  },
            success:function(response){
              if(response.success === true) {
                $(this).removeAttr("disabled")
                Swal.fire({
                  title: 'Client Updated',
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

          $('#edit_client_modal').modal('hide');
          $(this).removeAttr('disabled');

        });

        $('#client_delete').on('click', function(e) {
          e.preventDefault();

          var id = $(this).closest('#delete_client_modal').find(".id-to-update").val();
          var url = "{{ route('client.delete') }}";

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
                  title: 'Client Deleted',
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

          $('#delete_client_modal').modal('hide');
          $(this).removeAttr('disabled');

        });



        var myTable = $('#sample_data').DataTable({ 
              "processing" : true,
              "serverSide" : true,
              "stateSave": true,
              "ajax" : {
                  url:"{{ route('client.table') }}",
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
                      "data": "name",
                  },
                  { 
                      "data": "phone",
                  },
                  { 
                      "data": "address",
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
