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
    <div class="section-3">
        <div class="row">
        <div class="col-lg-6 col-md-6">
        <img src="/dist/img/denaku-intial.png" class="mt-1 w-100 h-100" alt="">
        </div>
        <div class="col-lg-6 col-md-6" id="para">
        <h5>CATERING</h5>
        <h1>Social Event</h1>
        <p class="text-justify">
        But I must explain to you how all this mistaken idea of <br> denouncing pleasure
        and praising pain was born and I <br> will give you a complete account
        of the system, and <br> expound the actual teachings of the great explorer
        of <br> the truth, the master-builder of human
        <p class="text-credit">READ MORE</p>
        </p>
        </div>
        </div>
        </div>
        <div class="section-4">
        <div class="row mt-5">
        <div class="col-md-6" id="para">
        <h5>CATERING</h5>
        <h1>Social Event</h1>
        <p class="text-justify">
        But I must explain to you how all this mistaken idea of <br> denouncing pleasure
        and praising pain was born and I <br> will give you a complete account
        of the system, and <br> expound the actual teachings of the great explorer
        of <br> the truth, the master-builder of human
        <p class="text-credit">READ MORE</p>
        </p>
        </div>
        <div class="col-md-6">
        <img src="/dist/img/denaku-intial.png" class="mt-1 w-100 h-100" alt="">
        </div>
        </div>
        </div>
</body>
</html>