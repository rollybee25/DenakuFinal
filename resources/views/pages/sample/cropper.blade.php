<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link rel="stylesheet" href="{{ asset('dist/cropper/cropper.css') }}">
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    img {
        display: block;
        width: 100%;
        height: 100%;
    }
    .image-holder {
        width: 700px;
        height: 500px;
        margin: 0 auto;
    }
    .preview {
        overflow: hidden;
        width: 100%; 
        height: 100%;
        border: 1px solid black;
        margin: 10px;
    }
</style>

<body>
    <div class="image-holder col-md-12 row">
        <div class="col-md-8">
            <img id="image" src="{{ asset('images/product/denaku.jpg') }}">
            <div class="row mt-2">
                <div class="btn-group col" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary move-crop" id="move-left">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                    <button type="button" class="btn btn-primary move-crop" id="move-right">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                    <button type="button" class="btn btn-primary move-crop" id="move-up">
                        <i class="fa fa-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-primary move-crop" id="move-down">
                        <i class="fa fa-arrow-down"></i>
                    </button>
                </div>
                <div class="btn-group col" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary rotate-crop" id="rotate-left">
                        <i class="fa fa-rotate-left"></i>
                    </button>
                    <button type="button" class="btn btn-primary rotate-crop" id="rotate-right">
                        <i class="fa fa-rotate-right"></i>
                    </button>
                </div>

                <div class="btn-group col" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary zoom-crop" id="zoom-in">
                        <i class="fa fa-search-plus"></i>
                    </button>
                    <button type="button" class="btn btn-primary zoom-crop" id="zoom-out">
                        <i class="fa fa-search-minus"></i>
                    </button>
                </div>
                <button class="btn btn-primary col" type="submit">Button</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="preview col">hey</div>
        </div>
    </div>

    
</body>
</html>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.js"></script> --}}
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('dist/cropper/cropper.js') }}"></script>
<script>
    
    const move_crop = document.querySelectorAll(".move-crop");
    const rotate_crop = document.querySelectorAll(".rotate-crop");
    const zoom_crop = document.querySelectorAll(".zoom-crop");

    const image = document.getElementById('image');
    const cropper = new Cropper(image, {
    preview: '.preview',
    aspectRatio: 4/3,
    crop(event) {
        console.log(event.detail.x);
        console.log(event.detail.y);
        console.log(event.detail.width);
        console.log(event.detail.height);
        console.log(event.detail.rotate);
        console.log(event.detail.scaleX);
        console.log(event.detail.scaleY);
    },
    });

    function for_move_crop(element) {
        if( element.id == "move-left" ) {
            cropper.move(-5,0);
        }
        if( element.id == "move-right" ) {
            cropper.move(5,0);
        }
        if( element.id == "move-up" ) {
            cropper.move(0,-5);
        }
        if( element.id == "move-down" ) {
            cropper.move(0,5);
        }
    }

    function for_rotate_crop(element) {
        if( element.id == "rotate-left" ) {
            cropper.rotate(-5);
        }
        if( element.id == "rotate-right" ) {
            cropper.rotate(5);
        }
    }

    function for_zoom_crop(element) {
        if( element.id == "zoom-in" ) {
            cropper.zoom(0.1);
        }
        if( element.id == "zoom-out" ) {
            cropper.zoom(-0.1);
        }
    }

    

    move_crop.forEach(element => {
        var timer = 0;
        element.addEventListener("mousedown", () => {
            timer = setInterval(() => {
                for_move_crop(element);
            }, 200);
        })
        element.addEventListener("click", () => {
            for_move_crop(element);
        })
        element.addEventListener("mouseup", () => {
            clearInterval(timer);
        })
    });

    rotate_crop.forEach(element => {
        var timer = 0;
        element.addEventListener("mousedown", () => {
            timer = setInterval(() => {
                for_rotate_crop(element);
            }, 200);
        })
        element.addEventListener("click", () => {
            for_rotate_crop(element);
        })
        element.addEventListener("mouseup", () => {
            clearInterval(timer);
        })
    });

    zoom_crop.forEach(element => {
        var timer = 0;
        element.addEventListener("mousedown", () => {
            timer = setInterval(() => {
                for_zoom_crop(element);
            }, 200);
        })
        element.addEventListener("click", () => {
            for_zoom_crop(element);
        })
        element.addEventListener("mouseup", () => {
            clearInterval(timer);
        })
    });








</script>