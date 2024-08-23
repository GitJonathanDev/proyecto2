<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@100;200;400;600;800;900&display=swap">
    <title>BODY FIT GYM</title>
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Barlow', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: #05080a;
            max-width: 100%;
            overflow-x: hidden;
        }

        .contenedor-header {
            width: 100%;
            position: fixed;
            border-bottom: 1px solid #1f283e;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99;
            padding: 0 20px;
        }

        .contenedor-header header {
            max-width: 1100px;
            margin: auto;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            color: #fff;
        }

        .txtRojo {
            color: #ff1133;
        }

        .contenedor-header header nav a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            padding: 5px;
            text-transform: uppercase;
        }

        .contenedor-header header nav a:hover {
            color: #ff1133;
        }

        .contenedor-header header .redes a {
            text-decoration: none;
            color: #fff;
            display: inline-block;
            padding: 5px 8px;
        }

        .contenedor-header header .redes a:hover {
            color: #ff1133;
        }

        .nav-responsive {
            display: none;
            font-size: 25px;
            cursor: pointer;
        }

        /* Responsive Menu */
        @media screen and (max-width: 768px) {
            .contenedor-header header {
                flex-wrap: wrap;
            }

            #nav {
                display: none;
                width: 100%;
                text-align: center;
                flex-direction: column;
            }

            #nav a {
                padding: 10px;
                border-bottom: 1px solid #1f283e;
            }

            .nav-right {
                margin-top: 10px;
            }

            .nav-responsive {
                display: block;
            }

            .contenedor-header header nav.active {
                display: flex;
            }
        }

        /* Otros estilos ya presentes */
        .inicio {
            height: 100vh;
            background: linear-gradient(rgba(0, 1, 3, 0.5), rgba(0, 0, 0, 0.7)), url(img/fondo.jpg);
            background-size: cover;
            background-position: center center;
            color: #fff;
            position: relative;
        }

        .inicio .contenido-seccion {
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }

        .inicio .info {
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .inicio .info h2 {
            font-size: 4rem;
            letter-spacing: 3px;
        }

        .inicio .info p {
            margin: 20px;
            color: #797e8e;
            font-size: 16px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .inicio .info .btn-mas {
            width: 50px;
            height: 50px;
            border: 2px solid #ff1133;
            border-radius: 50%;
            color: #ff1133;
            margin-top: 50px;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .opciones {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
        }

        .opciones .opcion {
            border-top: 2px solid #797e8e;
            padding: 7px;
            color: #797e8e;
            margin: 0 20px;
        }

        .servicios {
            position: relative;
            color: #fff;
        }

        .servicios .contenido-seccion {
            background: linear-gradient(rgba(0, 14, 41, 0.6), rgba(0, 7, 78, 0.7)), url(img/fondo-servicios.jpg);
            background-size: cover;
            background-position: center center;
            padding: 100px 20px;
        }

        .servicios .contenido-seccion .fila {
            max-width: 1100px;
            margin: auto;
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .servicios .contenido-seccion .fila .col {
            width: 50%;
        }

        .servicios .contenido-seccion .fila .col img {
            display: block;
            width: 100%;
            height: auto;
            max-width: 400px;
        }

        .servicios .contenido-seccion .fila .contenedor-titulo {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .servicios .contenido-seccion .fila .contenedor-titulo .numero {
            color: #ff1133;
            font-weight: bold;
            font-size: 5rem;
        }

        .servicios .contenido-seccion .fila .contenedor-titulo .info {
            flex: 1;
        }

        .servicios .contenido-seccion .fila .contenedor-titulo .info .frase {
            color: #ff1133;
            font-weight: bold;
        }

        .servicios .contenido-seccion .fila .contenedor-titulo .info h2 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .servicios .contenido-seccion .fila .col p {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .servicios .info-servicios {
            max-width: 800px;
            margin: auto;
        }

        .servicios .info-servicios table {
            width: 100%;
            text-align: center;
            background-color: #fff;
            color: #1f283e;
            border-collapse: collapse;
            margin-top: 50px;
        }

        .servicios .info-servicios table td {
            padding: 20px;
            border: 1px solid #dde1e9;
        }

        .servicios .info-servicios table td i {
            color: #ff1133;
            font-size: 2.5rem;
            margin-bottom: 10px;
            display: block;
        }

        .servicios .info-servicios h3 {
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .servicios .info-servicios p {
            line-height: 1.6;
        }

        .galeria {
            position: relative;
            color: #fff;
        }

        .galeria .contenido-seccion {
            background: linear-gradient(rgba(0, 14, 41, 0.6), rgba(0, 7, 78, 0.7)), url(img/fondo-galeria.jpg);
            background-size: cover;
            background-position: center center;
            padding: 100px 20px;
        }

        .galeria .fila {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .galeria .fila .col {
            flex: 1;
        }

        .galeria .fila .col img {
            width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: cover;
        }

        .galeria .contenedor-titulo {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .galeria .contenedor-titulo .numero {
            color: #ff1133;
            font-weight: bold;
            font-size: 5rem;
        }

        .galeria .contenedor-titulo .info {
            flex: 1;
            margin-left: 20px;
        }

        .galeria .contenedor-titulo .info h2 {
            font-size: 3rem;
        }

        .galeria .contenedor-titulo .info .frase {
            font-size: 20px;
        }

        .galeria .btn-ver-mas {
            width: 50px;
            height: 50px;
            border: 2px solid #ff1133;
            border-radius: 50%;
            color: #ff1133;
            margin-top: 50px;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .contacto {
            position: relative;
            color: #fff;
        }

        .contacto .contenido-seccion {
            background: linear-gradient(rgba(0, 14, 41, 0.6), rgba(0, 7, 78, 0.7)), url(img/fondo-contacto.jpg);
            background-size: cover;
            background-position: center center;
            padding: 100px 20px;
        }

        .contacto .contenido-seccion .fila {
            display: flex;
            justify-content: space-between;
            max-width: 1100px;
            margin: auto;
            gap: 40px;
        }

        .contacto .contenido-seccion .fila .col {
            flex: 1;
        }

        .contacto .contenido-seccion .fila .col h3 {
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .contacto .contenido-seccion .fila .col p {
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .contacto .contenido-seccion .fila .col iframe {
            width: 100%;
            height: 300px;
            border: none;
        }

        .btn-flotante {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #00bb2d;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 99;
        }
        #nav {
            display: flex;
            flex-direction: row;
        }

        @media screen and (max-width: 768px) {
            #nav {
                display: none;
                flex-direction: column;
                background-color: rgba(0, 0, 0, 0.8);
                position: absolute;
                top: 60px;
                right: 0;
                width: 100%;
            }

            #nav a {
                padding: 10px;
                border-bottom: 1px solid #fff;
                text-align: center;
            }

            .nav-responsive {
                display: block;
                cursor: pointer;
            }
        }

        .nav-active {
            display: flex !important;
        }
    </style>
</head>
<body>
    <!-- MENU -->
    <div class="contenedor-header">
        <header>
            <h1>BODY <span class="txtRojo">FIT</span></h1>
            <nav id="nav">
                <a href="#inicio">Inicio</a>
                <a href="#servicios">Servicios</a>
                <a href="#galeria">Galería</a>
                <a href="{{ route('login.index') }}">Iniciar Sesión</a>
                <div class="nav-right">
                    <a href="https://m.facebook.com/100063843083515/" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://wa.me/59177634194?text=Hola, quería hablar con un encargado del gimnasio." title="Whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://maps.app.goo.gl/JAjC77y7AMYtU9Am9" title="Ubicación"><i class="fas fa-map-marker-alt"></i></a>
                </div>
            </nav>
            <div id="icono-nav" class="nav-responsive">
                <i class="fas fa-bars"></i>
            </div>
        </header>
    </div>

    <!-- SECCION INICIO -->
    <section id="inicio" class="inicio">
        <div class="contenido-seccion">
            <div class="info">
                <h2>NO TENGAS MIEDO DE EMPEZAR <span class="txtRojo">DE CERO</span></h2>
                <p>El ejercicio no solo cambia el cuerpo, cambia tu mente, actitud y tu honor</p>
                <a href="#nosotros" class="btn-mas">
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
            <div class="opciones">
                <div class="opcion">01. FITNESS</div>
                <div class="opcion">02. CROSSFIT</div>
                <div class="opcion">03. ARTES MARCIALES MIXTAS</div>
                <div class="opcion">04. DEFENSA PERSONAL</div>
            </div>
        </div>
    </section>

    <!-- SECCION SERVICIOS -->
    <section class="servicios" id="servicios">
        <div class="contenido-seccion">
            <div class="fila">
                <div class="col">
                    <div class="contenedor-titulo">
                        <div class="numero">02</div>
                        <div class="info">
                            <span class="frase">DESCUBRE TU GRANDEZA</span>
                            <h2>SERVICIOS</h2>
                        </div>
                    </div>
                    <p class="p-especial">Levántate y entrena</p>
                    <p>El gimnasio Body Fit te brinda un lugar para ejercitarte con máquinas y artículos deportivos, además de ofrecer Crossfit y Artes Marciales.</p>
                </div>
                <div class="col">
                    <img src="img/servicios.png" alt="Servicios">
                </div>
            </div>
        </div>
    </section>

    <!-- SECCION GALERIA -->
    <section class="galeria" id="galeria">
        <div class="contenido-seccion">
            <div class="contenedor-titulo">
                <div class="numero">03</div>
                <div class="info">
                    <span class="frase">LA MEJOR EXPERIENCIA</span>
                    <h2>GALERÍA Y PROMOCIONES</h2>
                </div>
            </div>
            <div class="fila">
                <div class="col"><img src="img/logo (2).jpg" alt="Imagen 1"></div>
                <div class="col"><img src="img/logo (3).jpg" alt="Imagen 2"></div>
                <div class="col"><img src="img/img1.jpg" alt="Imagen 3"></div>
            </div>
            <div class="fila">
                <div class="col"><img src="img/img_2_1716433553368.jpg" alt="Imagen 4"></div>
                <div class="col"><img src="img/f5.jpg" alt="Imagen 5"></div>
                <div class="col"><img src="img/img_3_1716433581049.jpg" alt="Imagen 6"></div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById("icono-nav").addEventListener("click", function () {
            var nav = document.getElementById("nav");
            nav.classList.toggle("nav-active");
        });

        history.pushState(null, null, location.href);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, location.href);
    });
    </script>
</body>
</html>
