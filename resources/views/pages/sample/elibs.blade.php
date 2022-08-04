<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>
<style>
        img {
            border: 1px solid black;
        }
        .row{
        margin: 0;
        padding: 0;
        }
        #para{
        margin-top: 15%;
        font-style: italic;
        height: 100%;
        display: grid;
        align-items: center;
        justify-content: center;
        }
        .text-credit{
        font-weight: bold;
        font-style: normal;
        text-align: left;
        }
        .text-credit::before{
        content: "\2014\0020";
        }
        @media (max-width: 575.98px) {
        .section-4 .row {
        flex-direction: column-reverse;
        }
        }
        @media (max-width: 768px) { .section-4 .row {
        flex-direction: column-reverse;
        } }
</style>
<body>
    <div class="row">
        <div class="col-4">
            <div class="input-group mb-3">
                <input type="text" id="result" class="form-control" placeholder="QrCode / Barcode" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" id="scanner" type="button"><i class="fas fa-qrcode" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</body>
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="reader" style="width: 100%"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</html>
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 250, height: 250} },
    /* verbose= */ false);

    function onScanSuccess(decodedText, decodedResult) {
        
        html5QrcodeScanner.clear().then(_ => {
            $('#result').val(decodedText);
            $('.modal').modal('hide');
            html5QrcodeScanner.stop();
        })
        window.location.href = "{{ route('pos.view') }}"

    }

    function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
    // console.warn(`Code scan error = ${error}`);
    }

    $(document).ready(function() {
        $('#scanner').click(function()  {
            $('.modal').modal('show');
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        })

        $('.modal').on('hidden.bs.modal', function () {
            html5QrcodeScanner.clear()
            html5QrcodeScanner.stop()
        })
    })

</script>