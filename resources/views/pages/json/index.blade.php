<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="demo">
        <input type="text" name="" id="name">
    </div>
</body>
</html>
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function doesFileExist(urlToFile) {
            var xhr = new XMLHttpRequest();
            xhr.open('HEAD', urlToFile, false);
            xhr.send();
            
            if (xhr.status == "404") {
                return false;
            } else {
                return true;
            }
        }

        var file = "/json/product.json"
        var exist = doesFileExist(file);
        if(exist === true) {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                const myObj = JSON.parse(this.responseText);
                console.log(myObj)
            };
            xmlhttp.open("GET", file);
            xmlhttp.send();
        } else {
            var url = '{{ route('create-json-file') }}';
            $.ajax({
                url:url,
                method:'POST',
                data:{
                    json:file,
                },
                success:function(response){
                    if(response.success === true) {
                        Swal.fire({
                          title: 'Json Inserted',
                          text: 'Success',
                          icon: 'success',
                          confirmButtonText: 'Okay'
                        })
                    } else {
                        Swal.fire({
                          title: 'Error',
                          icon: 'error',
                          confirmButtonText: 'Okay'
                        })
                    }
                },
                error:function(error){
                  console.log(error)
                }
              });
        }


    });
</script>