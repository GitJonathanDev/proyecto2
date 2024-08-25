<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestionar vendedor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



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
            background: linear-gradient(rgba(0, 1, 3, 0.5), rgba(0, 0, 0, 0.7)), url('{{ asset('img/fondo.jpg') }}');
            position: fixed;
            top: 0;
            left: 0;
            width: 225px;
            height: 100%;
            padding: 30px 0;
            transition: all 0.5s ease;
            z-index: 1000;
            overflow-y: auto; 
        }
        
        .wrapper .sidebar .profile {
            margin-bottom: 30px;
            margin-top: 20px;
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
            overflow: hidden;
        }
        
        .wrapper .sidebar ul li a {
            display: block;
            padding: 15px 20px;
            color: #ffffff;
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
            background: linear-gradient(rgba(0, 1, 3, 0.5), rgba(0, 0, 0, 0.7)), url('{{ asset('img/fondo.jpg') }}');
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            display: flex;
            align-items: center;
            padding: 0;

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
        .btn-logout {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #e74c3c; 
    border: none;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.3s ease;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.btn-logout:hover {
    background-color: #c0392b; 
    transform: scale(1.05);
}

.btn-logout:active {
    background-color: #a93226; 
    transform: scale(0.95);
}

.btn-logout:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.5); 
}

        .btn {
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .btn i {
            margin-right: 10px;
        }

        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.5); 
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
            body.active .wrapper .sidebar {
            left: 0.001%;
        }
            
        }
         footer {
            background-color: #212529;
            color: #ffffff;
            text-align: center;
            padding: 2px;
            position: fixed;
            left: 0;
            bottom: 0;
            padding-bottom: 0;
            width: 100%;
            z-index: 1000;
        }
        .search-container {
    display: flex; 
    align-items: center; 
    position: relative;
    margin-left: 40px;
    flex: 1;
    max-width: 50%; 
}

#search-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    flex: 2;
    min-width: 250px;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    width: calc(100% - 2px);
    border: 1px solid #ccc;
    background-color: white;
    max-height: 200px;
    overflow-y: auto;
    display: none;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
}

.search-results ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.search-results li {
    padding: 8px;
    cursor: pointer;
}

.search-results li:hover {
    background-color: #f1f1f1;
}

        
    </style>
</head>
<body>
    @auth
    <div class="wrapper">
        <div class="sidebar">
            <div class="profile">
                <img src="{{ route('img.vendedor') }}" alt="profile_picture">
                <h3>{{ Auth::user()->nombreUsuario }}</h3>
                <p>{{ Auth::user()->tipoUsuario->descripcion }}</p>
            </div>
            <ul>
                @foreach($menus as $menu)
                <li>
                    <a href="{{ route($menu->url) }}">
                        <span class="icon"><i class="fas {{ $menu->icono }}"></i></span>
                        <span class="item">{{ $menu->nombre }}</span>
                    </a>
                    @if($menu->hijos->isNotEmpty())
                        <ul>
                            @foreach($menu->hijos as $hijo)
                                <li>
                                    <a href="{{ route($hijo->url) }}">
                                        <span class="icon"><i class="fas {{ $hijo->icono }}"></i></span>
                                        <span class="item">{{ $hijo->nombre }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
            </ul>
        </div>
        <div class="section">
            <div class="top_navbar">
                <div class="hamburger">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="logout-btn">
                    <form id="logout-form" action="{{ route('login.destroy') }}" method="POST">
                        @csrf
                        <a class="btn btn-logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                    </form>
                </div>
                <!-- Campo de búsqueda -->
                <div class="search-container">
                    <input type="text" id="search-input" placeholder="Buscar...">
                    <div id="search-results" class="search-results"></div>
                </div>
                
            </div>
            <div class="container">
                @yield('content', View::make('estadisticas'))
            </div>
        </div>
    </div>
    <footer>
        <h2>Cantidad de veces que se ha visitado esta página: {{ $conteoVisitas ?? '0' }}</h2>
    </footer>
    @yield('scripts')
    <!-- Botón pequeño pero visible en una esquina -->
    <a href="{{ route('menu.index2') }}" class="btn btn-invisible" style="position: fixed; bottom: 10px; right: 10px; width: 30px; height: 30px; background-color: transparent; border: 1px solid transparent; z-index: 9999; text-align: center; line-height: 30px; color: transparent; font-size: 16px;">🔗</a>
    <script>
        document.querySelector(".hamburger").addEventListener("click", function() {
            document.querySelector("body").classList.toggle("active");
        });

        document.getElementById('search-input').addEventListener('input', function() {
            let query = this.value;
            if (query.length > 0) {
                fetch("{{ route('buscar') }}?query=" + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        let searchResults = document.getElementById('search-results');
                        searchResults.style.display = 'block';
                        searchResults.innerHTML = '';
                        if (Object.keys(data).length > 0) {
                            let resultsList = '<ul>';
                            for (const [table, columns] of Object.entries(data)) {
                                columns.forEach(column => {
                                    resultsList += `<li><strong>${table}</strong> - ${column.columna}: ${column.coincidencias.join(', ')}</li>`;
                                });
                            }
                            resultsList += '</ul>';
                            searchResults.innerHTML = resultsList;
                        } else {
                            searchResults.innerHTML = '<p>No se encontraron resultados</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error en la búsqueda:', error);
                        document.getElementById('search-results').innerHTML = '<p>Error en la búsqueda</p>';
                    });
            } else {
                document.getElementById('search-results').style.display = 'none';
            }
        });

        document.addEventListener('click', function(event) {
            let searchContainer = document.querySelector('.search-container');
            if (!searchContainer.contains(event.target)) {
                document.getElementById('search-results').style.display = 'none';
            }
        });
    </script>
    @endauth
</body>



</html>