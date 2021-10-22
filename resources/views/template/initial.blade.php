<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistemas Vitais</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
</head>
<body>
    <div class="container-fluid">
        <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light"> 
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="navbar-toggler-icon"></span>
                    </button> <a class="navbar-brand" href="#">Sistemas Vitais - Módulo</a>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="navbar-nav">
                            
                            
                            @if(Route::is('login'))
                            <li class="nav-item active">
                                <li class="nav-link">Entre com seu login de usuário</li>    
                            </li>
                            <!-- 
                            <li class="nav-item active">
                                <a class="nav-link" href="{{route('home')}}">Home <span class="sr-only"></span></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="{{route('login')}}">Login <span class="sr-only"></span></a>
                            </li> -->
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Dropdown
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> Logout 
                                        <span class="sr-only"></span>
                                        
                                    </a>
                                </li> 
                            @endif
                            
                        </ul>
                    </div>
                </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="main">
                @yield('content')
            </div>
        </div>   
    </div>
</body>
</html>


<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/functions.js') }}" type="text/javascript"></script>
<script src="https://kit.fontawesome.com/4492c3903d.js" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/datatable.js') }}"></script>
@yield('js')
