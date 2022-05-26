<!DOCTYPE html>
<html>
<head>
    <title>Denaku Receipt</title>

    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            text-align: center;
            line-height: 35px;
        }

        footer {
            position: fixed; 
            bottom: -60px; 
            left: 0px; 
            right: 0px;
            height: 50px; 

            /** Extra personal styles **/
            text-align: center;
            line-height: 35px;
        }

        .logo-denaku{
            width: 350px;
            margin: 0;
        }

        .pagenum:before {
            content: "Page " counter(page) ".";
        }
    </style>

</head>


<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <img class="logo-denaku" src="{{ public_path('dist/img/logo.svg') }}">
    </header>

    <footer>
        <span class="pagenum"></span>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        @for ($i = 0; $i < 100; $i++)
            <div> {{ $i + 1 }}</div>
        @endfor

    </main>
</body>

</html>