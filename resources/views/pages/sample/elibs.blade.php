<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
            <div id="reader" style="width: 600px"></div>
        </div>
        <div class="col-4">
            <input type="button" id="scanner" />
            <input type="text" id="result" />
        </div>
    </div>
</body>
</html>
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: {width: 250, height: 250} },
    /* verbose= */ false);

    function onScanSuccess(decodedText, decodedResult) {
        $('#result').val(decodedText);
        html5QrcodeScanner.clear()
    }

    function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning.
    // for example:
    // console.warn(`Code scan error = ${error}`);
    }

    $(document).ready(function() {
        $('#scanner').click(function()  {
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        })
    })

</script>