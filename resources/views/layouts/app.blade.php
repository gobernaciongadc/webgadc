<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type='text/css'><!-- fontawesome 5.7.2 -->
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/jquery-ui.structure.min.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/jquery-ui.theme.min.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/jquery.dynatable.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/selectize.default.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/jquery.timepicker.min.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/jquery-confirm.min.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type='text/css'>
    <link href="{{ asset('css/customcombobox.css') }}" rel="stylesheet" type='text/css'>

    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- styles mterialize sobreescritos --}}
    <style type="text/css">

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu a::after {
            transform: rotate(-90deg);
            position: absolute;
            right: 6px;
            top: .8em;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-left: .1rem;
            margin-right: .1rem;
        }

        .dropdown-submenu:hover>a:after {
            border-left-color: #fff;
        }

        .dropdown-submenu.pull-left {
            float: none;
        }

        .dropdown-submenu:hover > a {
            color: #fff;
            text-decoration: none;
            background-color: #357ebd;
            background-image: -webkit-gradient(linear,left 0,left 100%,from(#428bca),to(#357ebd));
            background-image: -webkit-linear-gradient(top,#428bca,0%,#357ebd,100%);
            background-image: -moz-linear-gradient(top,#428bca 0,#357ebd 100%);
            background-image: linear-gradient(to bottom,#428bca 0,#357ebd 100%);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff428bca',endColorstr='#ff357ebd',GradientType=0);
        }

        .dropdown-submenu.pull-left>.dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }

        /*.dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            -webkit-border-radius: 0 6px 6px 6px;
            -moz-border-radius: 0 6px 6px;
            border-radius: 0 6px 6px 6px;
        }

        .dropdown-submenu:hover >.dropdown-menu {
            display: block;
        }

        .dropdown-submenu>a:after {
            display: block;
            content: " ";
            float: right;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #ccc;
            margin-top: 5px;
            margin-right: -10px;
        }

        .dropdown-submenu:hover>a:after {
            border-left-color: #fff;
        }

        .dropdown-submenu.pull-left {
            float: none;
        }

        .dropdown-submenu:hover > a {
            color: #fff;
            text-decoration: none;
            background-color: #357ebd;
            background-image: -webkit-gradient(linear,left 0,left 100%,from(#428bca),to(#357ebd));
            background-image: -webkit-linear-gradient(top,#428bca,0%,#357ebd,100%);
            background-image: -moz-linear-gradient(top,#428bca 0,#357ebd 100%);
            background-image: linear-gradient(to bottom,#428bca 0,#357ebd 100%);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff428bca',endColorstr='#ff357ebd',GradientType=0);
        }

        .dropdown-submenu.pull-left>.dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }*/

        .ui-datepicker-month{
            color:black;
        }
        .ui-datepicker-year{
            color:black;
        }
        .col-form-label{
            padding-top: 0;
            padding-bottom: 0;
        }

        .form-group{
            margin-bottom: 3px;
        }

        p{
            margin-bottom: 1px;
        }

        h3{
            margin-bottom: 1px;
        }
        .bg-azul{
            background-color: #0f3357;
        }
        .btn{
            margin: 2px;
        }
    </style>

    @yield('header_styles')
</head>
<body>
    @if (Auth::guest())

        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-azul {{-- bg-dark --}}">
            <a>
                <div class="carousel-item active">
                    <img class="d-block w-50" src="{{ asset('images/iconoTriton.png') }}" alt="First slide">
                </div>
            </a>
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarsExample04" style="">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">

                    </li>
                </ul>
                <div class="form-inline my-2 my-md-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Ingresar al Sistema</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @else
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-azul {{-- bg-dark --}}">
            <a>
                <div class="carousel-item active">
                    <img class="d-block w-50" src="{{ asset('images/iconoTriton.png') }}" alt="First slide">
                </div>
            </a>
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarsExample04" style="">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Organización
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink1">
                            <li><a class="dropdown-item @if(!verificarAcceso(73)) disabled @endif" href="{{url('sisadmin/unidaddespacho')}}">Despacho</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(75)) disabled @endif" href="{{url('sisadmin/unidadsecretaria')}}">Secretarias</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(80)) disabled @endif" href="{{url('sisadmin/unidaddireccion')}}">Direcciones</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(85)) disabled @endif" href="{{url('sisadmin/unidadunidad')}}">Unidades</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(90)) disabled @endif" href="{{url('sisadmin/unidadservicio')}}">Servicios</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mi Unidad
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                            @if(Auth::user()->unidad->tipoUnidad->tipo == 0)
                                <li><a class="dropdown-item @if(!verificarAcceso(1)) disabled @endif" href="{{url('sisadmin/unidaddespacho/editar/'.Auth::user()->und_id)}}">Mi Unidad</a></li>
                                <li><a class="dropdown-item @if(!verificarAcceso(2)) disabled @endif" href="{{url('sisadmin/imagenunidadgaleria/'.Auth::user()->und_id).'/unidaddespacho'}}">Galeria de Imagenes</a></li>
                            @elseif(Auth::user()->unidad->tipoUnidad->tipo == 1)
                                <li><a class="dropdown-item @if(!verificarAcceso(1)) disabled @endif" href="{{url('sisadmin/unidadsecretaria/editar/'.Auth::user()->und_id)}}">Mi Unidad</a></li>
                                <li><a class="dropdown-item @if(!verificarAcceso(2)) disabled @endif" href="{{url('sisadmin/imagenunidadgaleria/'.Auth::user()->und_id).'/unidadsecretaria'}}">Galeria de Imagenes</a></li>
                            @elseif(Auth::user()->unidad->tipoUnidad->tipo == 2)
                                <li><a class="dropdown-item @if(!verificarAcceso(1)) disabled @endif" href="{{url('sisadmin/unidaddireccion/editar/'.Auth::user()->und_id)}}">Mi Unidad</a></li>
                                <li><a class="dropdown-item @if(!verificarAcceso(2)) disabled @endif" href="{{url('sisadmin/imagenunidadgaleria/'.Auth::user()->und_id).'/unidaddireccion'}}">Galeria de Imagenes</a></li>
                            @elseif(Auth::user()->unidad->tipoUnidad->tipo == 3)
                                <li><a class="dropdown-item @if(!verificarAcceso(1)) disabled @endif" href="{{url('sisadmin/unidadunidad/editar/'.Auth::user()->und_id)}}">Mi Unidad</a></li>
                                <li><a class="dropdown-item @if(!verificarAcceso(2)) disabled @endif" href="{{url('sisadmin/imagenunidadgaleria/'.Auth::user()->und_id).'/unidadunidad'}}">Galeria de Imagenes</a></li>
                            @elseif(Auth::user()->unidad->tipoUnidad->tipo == 4)
                                <li><a class="dropdown-item @if(!verificarAcceso(1)) disabled @endif" href="{{url('sisadmin/unidadservicio/editar/'.Auth::user()->und_id)}}">Mi Unidad</a></li>
                                <li><a class="dropdown-item @if(!verificarAcceso(2)) disabled @endif" href="{{url('sisadmin/imagenunidadgaleria/'.Auth::user()->und_id).'/unidadservicio'}}">Galeria de Imagenes</a></li>
                            @else
                                <li><a class="dropdown-item @if(!verificarAcceso(1)) disabled @endif" href="#">Mi Unidad</a></li>
                            @endif

                            <li><a class="dropdown-item @if(!verificarAcceso(7)) disabled @endif" href="{{url('sisadmin/noticia/'.Auth::user()->und_id.'/lista')}}">Noticias</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(13)) disabled @endif" href="{{url('sisadmin/videosonido/'.Auth::user()->und_id)}}">Videos y Audios</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(18)) disabled @endif" href="{{url('sisadmin/convocatoria/'.Auth::user()->und_id.'/lista')}}">Convocatorias</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(23)) disabled @endif" href="{{url('sisadmin/estadistica/'.Auth::user()->und_id.'/lista')}}">Estadisticas</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(28)) disabled @endif" href="{{url('sisadmin/evento/'.Auth::user()->und_id.'/lista')}}">Eventos</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(33)) disabled @endif" href="{{url('sisadmin/documentolegal/'.Auth::user()->und_id.'/lista')}}">Documentos Legales</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(38)) disabled @endif" href="{{url('sisadmin/documento/'.Auth::user()->und_id.'/lista')}}">Documentos</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(43)) disabled @endif" href="{{url('sisadmin/publicacioncientifica/'.Auth::user()->und_id.'/lista')}}">Publicaciones Científicas</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(48)) disabled @endif" href="{{url('sisadmin/guiatramite/'.Auth::user()->und_id.'/lista')}}">Guía Trámites</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(53)) disabled @endif" href="{{url('sisadmin/serviciopublico/'.Auth::user()->und_id.'/lista')}}">Servicios Publicos</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(58)) disabled @endif" href="{{url('sisadmin/programa/'.Auth::user()->und_id.'/lista')}}">Programas</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(63)) disabled @endif" href="{{url('sisadmin/producto/'.Auth::user()->und_id.'/lista')}}">Productos</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(68)) disabled @endif" href="{{url('sisadmin/rendicioncuenta/'.Auth::user()->und_id.'/lista')}}">Rendición de Cuentas</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(153)) disabled @endif" href="{{url('sisadmin/proyecto/'.Auth::user()->und_id.'/lista')}}">Proyectos</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administración
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink3">
                            <li><a class="dropdown-item @if(!verificarAcceso(95)) disabled @endif" href="{{url('sisadmin/sugerencia')}}">Sugerencias</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(97)) disabled @endif" href="{{url('sisadmin/denuncia')}}">Denuncias</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(99)) disabled @endif" href="{{url('sisadmin/pregunta')}}">Encuestas</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(105)) disabled @endif" href="{{url('sisadmin/plan')}}">Planes</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(110)) disabled @endif" href="{{url('sisadmin/sistemaapoyo')}}">Sistema de apoyo</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(115)) disabled @endif" href="{{url('sisadmin/publicidad')}}">Publicidad</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tipologías
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink4">
                            <li><a class="dropdown-item @if(!verificarAcceso(120)) disabled @endif" href="{{url('sisadmin/biografia')}}">Biografias</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(124)) disabled @endif" href="{{url('sisadmin/hoyhistoria')}}">Hoy en la Historia</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(129)) disabled @endif" href="{{url('sisadmin/preguntafrecuente')}}">Preguntas Frecuentes</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(134)) disabled @endif" href="{{url('sisadmin/agendaoficial')}}">Agenda Oficial</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(139)) disabled @endif" href="{{url('sisadmin/ubicacion')}}">Ubicaciones</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Usuarios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink5">
                            <li><a class="dropdown-item @if(!verificarAcceso(143)) disabled @endif" href="{{url('sisadmin/roles')}}">Roles</a></li>
                            <li><a class="dropdown-item @if(!verificarAcceso(147)) disabled @endif" href="{{url('sisadmin/usuario/usuarios')}}">Usuarios</a></li>
                        </ul>
                    </li>



                </ul>
                <div class="form-inline my-2 my-md-0">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown03">
                                <a class="dropdown-item" href="{{ url('sisadmin/logout') }}"
                                   onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    Cerrar Sesión
                                </a>
                                <a class="dropdown-item" href="{{ url('/sisadmin/usuario/miperfil') }}">
                                    Editar Mi Perfil
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

    @endif

    @if(Auth::guest())
        <div class="container-fluid" style="padding-top: 64px;padding-bottom: 100px;">
            @yield('content')
        </div>
    @else
        <div class="container-fluid" style="padding-top: 64px;padding-bottom: 100px;">
            @yield('content')
        </div>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/toastr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dynatable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.numeric.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/selectize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-confirm.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.es.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/customcombobox.js') }}"></script>
    <!-- Section para agregar csrf token a todas las llamadas ajax de jquery -->
    <script type="text/javascript">
        $(function(){
            if (!$.fn.bootstrapDP && $.fn.datepicker && $.fn.datepicker.noConflict) {
                var datepicker = $.fn.datepicker.noConflict();
                $.fn.bootstrapDP = datepicker;
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script type="text/javascript" src="{{ asset('js/util.js') }}"></script>
    <!--Mensaje toastr-->
    {!! Toastr::message() !!}

    <script type="text/javascript">
        //CODIGO JAVASCRIPT PARA LOS DROPDOWNS SUBMENUS DEL NAVBAR
        $(function(){
            $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next(".dropdown-menu");
                $subMenu.toggleClass('show');


                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });


                return false;
            });
        });
        $(document).ready(function(){

        });
    </script>

    <!-- section for scripts -->
    @yield('footer_scripts')
</body>
</html>
