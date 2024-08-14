@extends('layouts.app')

@section('title', 'Registrar')

@section('content')
<div class="inicio" style="height: 100vh; background: linear-gradient(rgba(0, 1, 3, 0.7), rgba(0, 0, 0, 0.8)), url('{{ route('imagen.fondo') }}'); background-size: cover; background-position: center center; color: #fff; position: relative;">

        <div class="flex justify-center items-center h-screen">
            <form class="bg-white bg-opacity-50 shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4 w-full max-w-md" action="{{ route('login.create') }}" method="POST">
                @csrf
                <div class="mb-6 text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">INICIAR SESIÓN</h1>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-900 font-bold mb-2" for="email">
                        Correo electrónico
                    </label>
                    <div class="relative">
                        <i class="fas fa-user absolute top-1/2 transform -translate-y-1/2 left-3 text-gray-500"></i>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 pl-10 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="email" placeholder="" required>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-900 font-bold mb-2" for="password">
                        Contraseña
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute top-1/2 transform -translate-y-1/2 left-3 text-gray-500"></i>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 pl-10 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" placeholder="" required>
                        <button type="button" class="absolute top-1/2 transform -translate-y-1/2 right-3 text-gray-500" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                @error('message')
                    <p class="border border-red-500 rounded-md bg-red-100 text-red-600 p-2 my-2">{{ $message }}</p>
                @enderror
                <div class="flex items-center justify-between">
                    <button type="submit" class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline bg-gray-900 hover:bg-gray-800 transition-colors duration-300">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var passwordIcon = document.querySelector("#password + button i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
