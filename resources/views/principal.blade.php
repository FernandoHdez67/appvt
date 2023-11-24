<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cachorro PET es una aplicacion que
    ayuda a los usuarios a mejorar su experiencia de servicios y compras
    de productos de la clinica veterinaria">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('mystyle/mystyle.css') }}">

    {{--
    <link rel="stylesheet" href="{{ asset('mystyle/googlemaps.css') }}"> --}}
    <script src="//code.tidio.co/jy4xt97e32ubz1nmeqqt4jyrjt1kvend.js" async></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer>
    </script>
    <link rel="icon" href="{{ asset('img/icono.ico') }}">
    {{-- <script src="{{ asset('js/desactivarclickderecho.js') }}"></script> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <link rel="stylesheet" href="{{ asset('hover/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('hover/hover.css') }}">
    <script src="https://www.google.com/recaptcha/api.js?render=6LeacA8lAAAAAIiAfvQQbcF5DTHDRfIkI7SsP4kG"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LeacA8lAAAAAIiAfvQQbcF5DTHDRfIkI7SsP4kG', {
                action: 'formulario'
            });
        });

    </script>

    <script src="{{ asset('js/ajax.js') }}"></script>

    <style>
        .active-link {
            background-color: rgb(3, 151, 161);
            color: #E15116;
        }
    </style>

    <title>@yield('title')</title>

    @laravelPWA
</head>

<body>
    <div class="contentido">
        <nav class="navbar navbar-expand-lg navbar-light bg-primary" onclick="changeNavColor()">
            <div class="container-fluid">
                <a href="<?= route('inicio') ?>"><img src="{{ asset('img/icon-72x72.png') }}" width="50px" height="50px"
                        alt="logotipo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a href="#"></a>
                            <a style="color: white"
                                class="nav-link  <?php if(Route::current()->getName() == 'inicio') echo 'active-link'; ?> hvr-underline-from-left"
                                aria-current="page" href="<?= Route('inicio') ?>"><b><i class="fa-solid fa-house"></i>
                                    Inicio</b></a>
                        </li>
                        <li class="nav-item">
                            <a style="color: white"
                                class="nav-link <?php if(Route::current()->getName() == 'somos') echo 'active-link'; ?> hvr-underline-from-left"
                                aria-current="page" href="<?= Route('somos') ?>"><b><i
                                        class="fa-solid fa-circle-info"></i> Quienes somos</b></a>
                        </li>
                        <li class="nav-item">
                            <a style="color: white"
                                class="nav-link <?php if(Route::current()->getName() == 'productos') echo 'active-link'; ?> hvr-underline-from-left"
                                aria-current="page" href="{{ Route('productos') }}"><b><i
                                        class="fa-solid fa-shield-dog"></i> Productos</b></a>
                        </li>

                        <li class="nav-item">
                            <a style="color: white"
                                class="nav-link <?php if(Route::current()->getName() == 'servicios') echo 'active-link'; ?> hvr-underline-from-left"
                                aria-current="page" href="<?= Route('servicios') ?>"><b><i
                                        class="fa-solid fa-syringe"></i> Servicios</b></a>
                        </li>

                        <li class="nav-item">
                            <a style="color: white"
                                class="nav-link <?php if(Route::current()->getName() == 'citas') echo 'active-link'; ?> hvr-underline-from-left"
                                aria-current="page" href="<?= Route('citas') ?>"><b><i
                                        class="fa-regular fa-calendar-days"></i> Citas</b></a>
                        </li>
                        <li class="nav-item">
                            <a style="color: white"
                                class="nav-link <?php if(Route::current()->getName() == 'ayuda') echo 'active-link'; ?> hvr-underline-from-left"
                                aria-current="page" href="<?= Route('ayuda') ?>"><b><i
                                        class="fa-solid fa-circle-question"></i> Ayuda</b></a>
                        </li>
                    </ul>
                    <a style="text-decoration: none; color:white" href="{{ route('carrito.index') }}">
                        <b style="margin-right: 10px">
                            <i class="fa-solid fa-cart-plus fa-xl" style="color: #ffffff;"></i>
                            @php
                            // Obtener la cantidad total de productos en el carrito para el usuario actual
                            $cantidadTotalEnCarrito = \App\Models\Carrito::where('idusuario',
                            session('idusuario'))->sum('cantidad');
                            @endphp
                            @if ($cantidadTotalEnCarrito > 0)
                            <span class="badge bg-secondary">{{ $cantidadTotalEnCarrito }}</span>
                            @endif
                        </b>
                    </a>


                    {{-- <img src="{{ asset('img/carrito2.png') }}" width="40px" height="30px" alt=""> --}}
                    @if (session()->has('idusuario'))
                    <div class="btn-group">
                        <a class="btn btn-rojopet dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user"></i> <b>{{ session('nombreUsuario') }}</b>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('perfilusuario.editar') }}"><i
                                        class="fa-solid fa-user"></i> Mi perfil</a></li>
                            <li><a class="dropdown-item" href="{{ route('miscitas') }}"><i
                                        class="fa-solid fa-calendar-check"></i> Mis citas</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-money-check"></i> Mis compras</a>
                            </li>
                            <form action="{{ route('logoute') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit"><i
                                        class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</button>
                            </form>
                        </ul>
                    </div>

                    @else
                    <a class="btn btn-rojopet" href="{{ route('iniciar') }}"><b style="color: white"><i
                                class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión</b></a>
                    @endif
                </div>
            </div>
        </nav>
    </div>


    <div id="resultado" class="col-sm-12">
        @yield('contenido')
    </div>


    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();

    </script>

</body>
<footer class="bg-dark text-white pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>Cachorro PET</h3>
                <hr>
                <ul class="list-unstyled text-secondary">
                    <li><a class="text-decoration-none link-secondary" href="{{ Route('somos') }}">Quienes somos</a>
                    </li>
                    <li><a class="text-decoration-none link-secondary" href="{{ route('politicas') }}">Términos y
                            Condiciones</a></li>
                    <li><a target="_blank" class="text-decoration-none link-secondary"
                            href="{{ asset('archivos/Aviso de privacidad.pdf') }}">Aviso de privacidad</a></li>
                    <li><a class="text-decoration-none link-secondary" href="{{ route('ayuda') }}">Ayuda</a></li>
                </ul>

            </div>
            <div class="col-md-3">
                <h3>Contacto</h3>
                <hr>
                <ul class="list-unstyled text-secondary">
                    <li><i class="fa-brands fa-twitter"></i> <a class="text-decoration-none link-secondary"
                            href="#">Twitter</a></li>
                    <li><i class="fa-brands fa-square-facebook"></i> <a class="text-decoration-none link-secondary"
                            href="https://web.facebook.com/CachorroPetClinicaVeterinaria" target="_blank">Facebook</a>
                    </li>
                    <li><i class="fa-brands fa-instagram"></i> <a class="text-decoration-none link-secondary"
                            href="#">Instagram</a></li>
                    <li><i class="fa-solid fa-envelope"></i> <a class="text-decoration-none link-secondary"
                            href="{{ route('contacto') }}">Contacto</a></li>

            </div>
            <div class="col-md-3">
                <h3>Servicios</h3>
                <hr>
                <ul class="list-unstyled text-secondary">
                    <li><a class="text-decoration-none link-secondary" href="{{ route('servicios') }}">Esterica
                            canina</a></li>
                    <li><a class="text-decoration-none link-secondary" href="{{ route('servicios') }}">Ultrasonido</a>
                    </li>
                    <li><a class="text-decoration-none link-secondary" href="{{ route('servicios') }}">Cirugias</a></li>
                    <li><a class="text-decoration-none link-secondary" href="{{ route('servicios') }}">Otros</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>Dirección</h3>
                <hr>
                <ul class="list-unstyled text-secondary">

                    <li>
                    <li>Adolfo López Mateos 34
                        Aviación Civil
                        43000 Huejutla, Hgo.
                        México</li>
                    </li>
                </ul>
            </div>
            <hr>
            <center>
                <p class="text-decoration-none link-secondary">&copy;
                    <?php echo date("Y"); ?> Todos los derechos reservados
                </p>
            </center>
        </div>
    </div>
</footer>

</html>
