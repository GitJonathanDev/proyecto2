<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar vendedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.1/tailwind.min.css">


   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
        
        * {
            list-style: none;
            text-decoration: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }
        
        body {
            background: #f5f6fa;
            margin: 0;
        }
        
        .wrapper {
            display: flex;
        }
        
        .wrapper .sidebar {
            background: #2c3e50; 
            position: fixed;
            top: 0;
            left: 0;
            width: 225px;
            height: 100%;
            padding: 30px 0;
            transition: all 0.5s ease;
            z-index: 1000;
        }
        
        .wrapper .sidebar .profile {
            margin-bottom: 30px;
            text-align: center;
            padding: 20px 0; 
        }
        
        .wrapper .sidebar .profile img {
            display: block;
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
        }
        
        .wrapper .sidebar .profile h3 {
            color: #fff;
            margin: 10px 0 5px;
        }
        
        .wrapper .sidebar .profile p {
            color: #999999;
            font-size: 14px;
        }
        
        .wrapper .sidebar ul {
            padding-left: 0; 
        }
        
        .wrapper .sidebar ul li a {
            display: block;
            padding: 15px 20px; 
            color: #999999;
            font-size: 16px;
            position: relative;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .wrapper .sidebar ul li a .icon {
            margin-right: 10px;
        }
        
        .wrapper .sidebar ul li a:hover,
        .wrapper .sidebar ul li a.active {
            color: #fff;
            background-color: #34495e;
        }
        
        .wrapper .section {
            margin-left: 225px; 
            transition: all 0.5s ease;
            padding: 20px;
            width: calc(100% - 225px); 
            margin-top: 80px; 
        }
        
        .wrapper .section .top_navbar {
            background: #2c3e50;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            display: flex;
            align-items: center;
            padding: 0;
            border-bottom: 1px solid #34495e; 
            z-index: 1050; 
        }
        
        .wrapper .section .top_navbar .hamburger {
            font-size: 24px;
            color: #fff;
            cursor: pointer; 
            padding: 0 20px; 
        }
        
        .container {
            background: #ecf0f1; 
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }
        
        body.active .wrapper .sidebar {
            left: -225px;
        }
        
        @media (max-width: 768px) {
            .wrapper .sidebar {
                left: -225px;
            }
            .wrapper .section {
                margin-left: 0;
                margin-right: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <div class="profile">
                <img src="../img/vendedor.png" alt="profile_picture">
                <h3></h3>
                <p>Administrador</p>
            </div>
            <ul>
                <li>
                    <a href="#" class="active">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">INICIO</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('vendedor.index')}}">
                        <span class="icon"><i class="fas fa-chart-line"></i></span>
                        <span class="item">Gestionar vendedor</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('tipoUsuario.index')}}">
                        <span class="icon"><i class="fas fa-chart-pie"></i></span>
                        <span class="item">Gestionar Tipos de usuario</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('usuario.index')}}">
                        <span class="icon"><i class="fas fa-chart-pie"></i></span>
                        <span class="item">Gestionar usuarios</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="section">
            <div class="top_navbar">
                <div class="hamburger">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        document.querySelector(".hamburger").addEventListener("click", function() {
            document.querySelector("body").classList.toggle("active");
        });
    </script>
</body>
</html>
