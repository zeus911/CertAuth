<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '') }}</title>

    <!-- .ico -->
    <link rel="icon" href="{{URL::asset('favicon.ico') }}"/>

    <!-- Scripts -->
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.csss"> -->


    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#dashboard').DataTable();
            var first = $.noConflict(true);
        } );
    </script>

    <!-- <script type="text/javascript" class="init">
        $(document).ready(function() {
            var table = $('#dashboard').DataTable( {
                responsive: true
            } );
            new $.fn.dataTable.FixedHeader( table );
        } );
    </script> -->

    <!-- Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('certs/mgmt') }}">
                    {{--  <strong>{{ config('app.name', '') }} <span class="badge badge-light">PoC</span></strong>  --}}
                    <h2><span class="badge badge-light">CertAuth PoC</span></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="certificate" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><strong><i class="fas fa-certificate"></i> Certificates</strong></a>
                            <ul class="dropdown-menu" aria-labelledby="certificate">
                                <li class="dropdown-item"><a href="{{ url('dashboard') }}"><strong class="text-danger"><i class="fas fa-chart-bar"></i> DASHBOARD</strong></a></li>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header"><strong>CERTIFICATES</strong></h6>
                                <li class="dropdown-item" data-toggle="tooltip" data-placement="right" title="Generates the CSR + Public Key + Private Key"><a href="{{ url('certs/create') }}"><i class="fas fa-plus"></i><strong> New Certificate </strong></a></li>
                                <li class="dropdown-item" data-toggle="tooltip" data-placement="right" title="Generates the CSR + Private Key"><a href="{{ url('csr/create') }}"><i class="fas fa-plus"></i><strong> New Certificate Server Request </strong></a></li>
                                <li class="dropdown-item" data-toggle="tooltip" data-placement="right" title="Saves the CSR & generate Public Key"><a href="{{ url('csr/sign') }}"><i class="fas fa-file-signature"></i><strong> Sign Certificate Server Request </strong></a></li>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header"><strong>ROOT & CRL</strong></h6>
                                <li class="dropdown-item"><a href="{{ url('rootcrl/root') }}"><i class="fas fa-cloud-download-alt"></i><strong> Download Root Certificate(s) </strong></a></li>
                                <li class="dropdown-item"><a href="{{ url('rootcrl/crl') }}"><i class="fas fa-cloud-download-alt"></i><strong> Update & Download CRL(s) </strong></a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="jarsigner" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><strong><i class="fas fa-archive"></i> JAR Signer</strong></a>
                            <ul class="dropdown-menu" aria-labelledby="jarsigner">
                                <li class="dropdown-item"><a href="{{ url('signer/jar') }}"><i class="fas fa-file-signature"></i><strong> Sign a Java Archive </strong></a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="authenticode" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><strong><i class="fab fa-windows"></i> Microsoft Authenticode</strong></a>
                            <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="authenticode">
                                    <a class="dropdown-item text-primary" href="{{ url('signer/authenticode') }}"><i class="fas fa-file-signature"></i><strong> Sign a Microsoft Archive </strong></a>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="converter" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre><strong><i class="fas fa-tools"></i> SSL Tools</strong></a>
                            <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="converter">
                                <h6 class="dropdown-header"><strong>CERTIFICATE CONVERTER</strong></h6>
                                    <li class="dropdown-item"><a href="{{ url('converter/p12') }}"><i class="fas fa-exchange-alt"></i><strong> Convert to PFX/P12 </strong></a></li>
                                    <li class="dropdown-item"><a href="{{ url('converter/pem2der') }}"><i class="fas fa-exchange-alt"></i><strong> Convert PEM to DER </strong></a></li>
                                    <li class="dropdown-item"><a href="{{ url('converter/der2pem') }}"><i class="fas fa-exchange-alt"></i><strong> Convert DER to PEM </strong></a></li>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header"><strong>JAVA KEYSTORE</strong></h6>
                                    <li class="dropdown-item"><a href="{{ url('converter/keystore') }}"><i class="fas fa-exchange-alt"></i><strong> Create Keystore </strong></a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="login" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <strong><i class="fas fa-user-astronaut"></i> {{ Auth::user()->name }} <span class="caret"></span></strong>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="login">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <strong><i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}</strong>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script type="text/javascript">
        var first= $.noConflict(true);
    </script>
</body>
</html>
