<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Gimnasio BodyFit')</title>
  @stack('styles')
  
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link id="theme-style" rel="stylesheet" href="{{ asset('css/estiloPagClienteOscuro.css') }}">
  
  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    .content {
      flex: 1;
      margin-bottom: 60px; 
    }
    footer {
      background-color: #212529;
      color: #ffffff;
      text-align: center;
      padding: 2px;
      position: relative;
      width: 100%;
      bottom: 0;
      left: 0;
    }
    .navbar-nav {
      align-items: center;
    }
    .theme-switch-wrapper {
      display: flex;
      align-items: center;
      margin-left: 15px;
    }
    .theme-switch {
      display: inline-block;
      height: 34px;
      position: relative;
      width: 60px;
    }
    .theme-switch input {
      display: none;
    }
    .slider {
      background-color: #ccc;
      bottom: 0;
      cursor: pointer;
      left: 0;
      position: absolute;
      right: 0;
      top: 0;
      transition: .4s;
    }
    .slider:before {
      background-color: white;
      bottom: 4px;
      content: "";
      height: 26px;
      left: 4px;
      position: absolute;
      transition: .4s;
      width: 26px;
    }
    input:checked + .slider {
      background-color: #2196F3;
    }
    input:checked + .slider:before {
      transform: translateX(26px);
    }
    .slider.round {
      border-radius: 34px;
    }
    .slider.round:before {
      border-radius: 50%;
    }
  </style>
</head>
<body>
  @auth

  <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
    <div class="container-fluid">

      <a class="navbar-brand" href="#">Gimnasio <span id="bo">Body Fit</span></a>


      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
  
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('mis-membresias') }}">Mis membresías</a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cliente') }}">Comprar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://wa.me/59177634194?text=Hola, quería hablar con un encargado del gimnasio." target="_blank">Contacto</a>
          </li>
          @if (!empty($showCartIcon))
          <li class="nav-item">
            <a class="nav-link mr-4" href="#" id="cart-icon">
              <i class="fas fa-shopping-cart"></i> Carrito <span class="cart-badge">0</span>
            </a>
          </li>
          @endif
        </ul>

   
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">
              Bienvenido, {{ Auth::user()->nombreUsuario }}
            </a>
          </li>
          <li class="nav-item">
            <form id="logout-form" action="{{ route('login.destroy') }}" method="POST">
              @csrf
              <a id="logout-button" class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar sesión
              </a>
            </form>
          </li>
          <li class="nav-item dropdown d-flex align-items-center">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="themeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i id="theme-icon" class="fas fa-adjust fa-lg"></i> Temas
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="themeDropdown">
                <form class="px-4 py-3">
                  <div class="form-group mb-3">
                    <label for="theme-select" class="form-label">Selecciona un tema:</label>
                    <select id="theme-select" class="form-select">
                      <option value="defecto">Tema por defecto</option>
                      <option value="ninos">Tema niños</option>
                      <option value="jovenes">Tema jóvenes</option>
                      <option value="adultos">Tema adultos</option>
                    </select>
                  </div>
                </form>
              </div>
            </div>
            <div class="theme-switch-wrapper">
              <label class="theme-switch" for="toggle-theme-btn">
                <input type="checkbox" id="toggle-theme-btn">
                <span class="slider round"></span>
              </label>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container content mt-5">
    @yield('content')
  </div>


  <footer>
    <h2>Cantidad de veces que se ha visitado esta página: {{ $conteoVisitas ?? '0' }}</h2>
  </footer>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const select = document.getElementById('theme-select');
      const themeStyle = document.getElementById('theme-style');
      const themeToggle = document.getElementById('toggle-theme-btn');
      const themeIcon = document.getElementById('theme-icon');

      const savedTheme = localStorage.getItem('theme') || 'defecto';
      const savedMode = localStorage.getItem('mode') || 'Oscuro';
      updateTheme(savedTheme, savedMode);

      select.value = savedTheme;
      themeToggle.checked = savedMode === 'Claro';

      select.addEventListener('change', function() {
        const selectedTheme = this.value;
        localStorage.setItem('theme', selectedTheme);
        updateTheme(selectedTheme, savedMode);
      });

      themeToggle.addEventListener('change', function() {
        const newMode = themeToggle.checked ? 'Claro' : 'Oscuro';
        const theme = localStorage.getItem('theme') || 'defecto';
        updateTheme(theme, newMode);
        localStorage.setItem('mode', newMode);
      });

      function updateTheme(theme, mode) {
        let themePath = '';
        if (theme === 'defecto') {
          themePath = mode === 'Claro' ? '{{ asset('css/estiloPagClienteClaro.css') }}' : '{{ asset('css/estiloPagClienteOscuro.css') }}';
        } else if (theme === 'ninos') {
          themePath = mode === 'Claro' ? '{{ asset('css/estiloPagNinoClaro.css') }}' : '{{ asset('css/estiloPagNinoOscuro.css') }}';
        } else if (theme === 'jovenes') {
          themePath = mode === 'Claro' ? '{{ asset('css/estiloPagJovenOscuro.css') }}' : '{{ asset('css/estiloPagJovenClaro.css') }}';
        } else if (theme === 'adultos') {
          themePath = mode === 'Claro' ? '{{ asset('css/estiloPagAdultoClaro.css') }}' : '{{ asset('css/estiloPagAdultoOscuro.css') }}';
        }

        themeStyle.href = themePath;
        themeIcon.className = mode === 'Claro' ? 'fas fa-sun fa-lg' : 'fas fa-moon fa-lg';
      }
    });
  </script>

  @stack('scripts')
  @endauth
</body>
</html>
