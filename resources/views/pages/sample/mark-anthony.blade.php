<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mark Anthony</title>
</head>
<body>
    <input type="button" id="kahitAno" class="kahit-ano" value="Kahit Ano" />
    <img id="images" src="{{asset('images/product/denaku.jpg')}}" alt="" style="display: none">
</body>
</html>

<script>
    var kahitAno = document.getElementById('kahitAno');
    var images = document.getElementById('images');

    kahitAno.addEventListener('click', function() {
        images.style.display = 'block';
        this.style.display = 'none';
    })


    
</script>