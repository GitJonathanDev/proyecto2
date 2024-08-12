<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categorías de Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    #productosContainer .bg-white {
        width: calc(100% / 3 - 1rem); 
        margin-right: 1rem;
        margin-bottom: 1rem;
        flex: 1 0 30%; 
        box-sizing: border-box;
    }

    .categoria-link.active {
        font-weight: bold;
        color: #4CAF50; 
    }
</style>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <header class="bg-gray-200 p-4 mb-6 relative">
            <h1 class="text-xl font-bold">Categorías de Productos</h1>
            <div id="carritoIcono" class="absolute top-0 right-0 bg-blue-500 text-white rounded-full h-6 w-6 flex items-center justify-center">
                <i class="fas fa-shopping-cart"></i>
                <span id="contadorCarrito" class="text-sm">0</span>
            </div>
        </header>
        
        <div class="flex flex-wrap" id="categoriasContainer">
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 mb-4 px-2">
                <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition duration-300">
                    <a href="#" class="text-blue-600 hover:text-blue-800 block font-semibold text-lg mb-2 categoria-link active" data-id="todos">Todos</a>
                </div>
            </div>

            @foreach($categorias as $categoria)
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 mb-4 px-2">
                <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition duration-300">
                    <a href="#" class="text-blue-600 hover:text-blue-800 block font-semibold text-lg mb-2 categoria-link" data-id="{{ $categoria->id }}">{{ $categoria->nombre }}</a>
                </div>
            </div>
            @endforeach
        </div>

        <div id="productosContainer" class="mt-6 flex flex-wrap">
            <!-- Productos cargados dinámicamente aquí -->
        </div>
        
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoriaLinks = document.querySelectorAll('.categoria-link');
            const carritoIcono = document.getElementById('carritoIcono');
            const contadorCarrito = document.getElementById('contadorCarrito');

            let carrito = []; 

            categoriaLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const categoriaId = this.getAttribute('data-id');
                    mostrarProductos(categoriaId);

                    categoriaLinks.forEach(link => link.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            mostrarProductos('todos');

            function mostrarProductos(categoriaId) {
                let endpoint = '/api/venta/productos'; 

                if (categoriaId !== 'todos') {
                    endpoint = `/api/categorias/${categoriaId}/productos`; 
                }

                axios.get(endpoint)
                    .then(response => {
                        const productos = response.data;
                        const productosContainer = document.getElementById('productosContainer');
                        productosContainer.innerHTML = ''; 

                        productos.forEach(producto => {
                            const productoHTML = `
                                <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                                    <h2 class="text-lg font-semibold mb-2">${producto.nombre}</h2>
                                    <p class="text-gray-700">${producto.descripcion}</p>
                                    <p class="text-gray-700 font-bold mt-2">$${producto.precio}</p>

                                    <div class="mt-4 flex justify-between items-center">
                                        <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md mr-2 btn-comprar" data-id="${producto.codProducto}">Comprar</button>
                                        <button class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md btn-agregar-carrito" data-id="${producto.codProducto}">Agregar a carrito</button>
                                    </div>
                                </div>
                            `;
                            productosContainer.innerHTML += productoHTML;
                        });

                        const btnsComprar = document.querySelectorAll('.btn-comprar');
                        btnsComprar.forEach(btn => {
                            btn.addEventListener('click', comprarProducto);
                        });

                        const btnsAgregarCarrito = document.querySelectorAll('.btn-agregar-carrito');
                        btnsAgregarCarrito.forEach(btn => {
                            btn.addEventListener('click', agregarAlCarrito);
                        });
                    })
                    .catch(error => {
                        console.error('Error al obtener los productos:', error);
                    });
            }

            function comprarProducto(event) {
                const productId = event.target.getAttribute('data-id');
                window.location.href = `/comprar/${productId}`; 
            }

            function agregarAlCarrito(event) {
                const productId = event.target.getAttribute('data-id');
                const productoSeleccionado = getProductById(productId);

                if (productoSeleccionado) {
                    carrito.push(productoSeleccionado);
                    actualizarContadorCarrito();
                }
            }

            function getProductById(productId) {
                const productosMostrados = document.querySelectorAll('#productosContainer .bg-white');
                
                for (let i = 0; i < productosMostrados.length; i++) {
                    const btnAgregarCarrito = productosMostrados[i].querySelector('.btn-agregar-carrito');
                    
                    if (btnAgregarCarrito) {
                        const idProducto = btnAgregarCarrito.getAttribute('data-id');
                        
                        if (idProducto === productId) {
                            return {
                                id: idProducto,
                                nombre: productosMostrados[i].querySelector('.text-lg').textContent,
                                descripcion: productosMostrados[i].querySelector('.text-gray-700').textContent,
                                precio: parseFloat(productosMostrados[i].querySelector('.font-bold').textContent.replace('$', ''))
                            };
                        }
                    }
                }
                
                return null;
            }

            function actualizarContadorCarrito() {
                contadorCarrito.textContent = carrito.length;
                carritoIcono.classList.add('animate-pulse'); 

                setTimeout(() => {
                    carritoIcono.classList.remove('animate-pulse');
                }, 500);
            }
        });
    </script>
</body>
</html>
