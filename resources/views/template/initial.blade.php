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
            <a class="navbar-brand" href="#">Sistemas Vitais | Modulo - </a>
            <button 
                class="navbar-toggler" 
                type="button" 
                data-toggle="collapse" 
                data-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" 
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                @if (Session::get('nivel_id')) {{-- Se o usuário for admin --}} 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administrar
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        
                        <a class="dropdown-item" href="{{Route('home.admin')}}">Home Admin</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ Route('hospitais') }}">Hospitais</a>
                        <a class="dropdown-item" href="{{ Route('sistemas') }}">Sistemas</a>
                        <a class="dropdown-item" href="{{ Route('equipamentos') }}">Equipamentos</a>
                        <a class="dropdown-item" href="{{ Route('ocorrencias') }}">Ocorrencias</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{Route('usuarios')}}">Usuários</a>
                    </div>
                </li>          
                @endif 
                
                @if (Session::get('nivel_id'))
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i> Logout </a>
                        <span class="sr-only"></span>
                        
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
