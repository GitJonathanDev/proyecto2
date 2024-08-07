<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.1/tailwind.min.css">
    <style>
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #111827;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /
        }

        body {
            padding-top: 80px;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    
    <nav class="flex items-center py-6 text-white">
        <div class="w-full px-4 md:w-1/2 md:px-12 mr-auto">
            <p class="text-2xl font-bold"><i class="fas fa-dumbbell"></i> BODY FIT</p>
        </div>
        <ul class="w-full px-4 md:w-1/2 md:px-16 ml-auto flex justify-end pt-1 space-x-6 md:space-x-8">
            @if (auth()->check())
                <li>
                    <p class="text-xl">Bienvenido <b>{{ auth()->user()->name }}</b></p>
                </li>
                <li>
                    <a href="{{ route('login.destroy')}}" class="font-semibold border-2 border-white py-2 px-4 rounded-md hover:bg-white hover:text-indigo-500">SALIR</a>
                </li>
            @else
                <li>
                    <a href="{{ route('login.index')}}" class="font-semibold hover:bg-blue-700 py-3 px-4 rounded-md">Iniciar sesión</a>
                </li>
                <li>
                    <a href="{{ route('registrar.index')}}" class="font-semibold py-3 px-4 rounded-md hover:bg-blue-700">Registrar</a>
                </li>
            @endif
        </ul>
    </nav>
    
    @yield('content')

</body>
</html>
