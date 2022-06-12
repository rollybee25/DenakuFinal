<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mark Anthony</title>
</head>

<style>
        @font-face {
			font-family: 'password';
			font-style: normal;
			font-weight: 400;
			src: url('https://jsbin-user-assets.s3.amazonaws.com/rafaelcastrocouto/password.ttf');
			/* src: url("js/password/password.ttf"); */
		}

        p.input-password {
			font-family: 'password';
			width: 100px;
            padding: 2px;
			border: 1px solid blue;
			border-radius: 5px;
            -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
            -moz-box-sizing: border-box;    /* Firefox, other Gecko */
            box-sizing: border-box;         /* Opera/IE 8+ */
			outline: none;
		}
</style>
<body>
    <label for="password" class="col-md-3 col-form-label">Password:  </label>
    <p class="input-password" id="password" contenteditable="true" spellcheck="false"></p>
</body>
</html>

