<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', '') }}</title>

    <!-- .ico -->
    <link rel="icon" href="{{URL::asset('favicon.ico') }}"/>

    <!-- Styles -->
    <link href="/css/login.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <!-- <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet"> -->

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
         <nav class="navbar navbar-default navbar-static-top">
                <div class="navbar-header"> 
        
                            <!-- Collapsed Hamburger -->
        <!--           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
        -->
                    <!-- Branding Image -->
                    {{--  <a class="navbar-brand" href="{{ url('certs/mgmt') }}">
                    <div class="container"><img src="{{URL::asset('/img/logo.gif')}}" alt="LIQUABIT - Home"></div>
                        {{ config('app.name', 'CertAuth {PoC}') }}
                    </a>  --}}
                </div>
        </nav>
        
        @yield('content')

    </div>

    <br />
    <!-- footer -->

    <div class="container">
        <div class="text-info"><center><strong>{<i class="fab fa-product-hunt"></i>rototypes}, 2016 - {{ date('F Y') }}.</strong></center></div>
        <div class="text-muted"><center><strong><i class="fa fa-quote-left" aria-hidden="true"></i> Learn from yesterday, live for today, hope for tomorrow. The important thing is not to stop questioning...<i class="fa fa-quote-right" aria-hidden="true"></i></strong></center></div>
    </div>
</div>

    <script src="/js/app.js"></script>

</body>
</html>
