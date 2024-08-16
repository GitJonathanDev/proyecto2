@extends('layouts.clienteBase')

@section('title', 'Gimnasio BodyFit')

@php
  $showCartIcon = true;
@endphp

@section('content')
<!-- Contenido principal -->
<div class="container mt-3">
  <div class="row justify-content-center mb-4">
    <div class="col-12 text-center">
      <h2 class="font-weight-bold" style="font-size: 2rem;">
        <em>¡Encuentra todo lo que necesitas para tu entrenamiento aquí!</em>
      </h2>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-md-4">
      <select id="categoriaSelector" class="custom-select">
        <option value="">Todas las categorías</option>

      </select>
    </div>
  </div>
  <div class="row justify-content-center" id="productosContainer">
    <!-- Los productos se cargarán aquí -->
  </div>
</div>

<!-- Modal del carrito -->
<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cartModalLabel">Carrito de Compras</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul id="cart-modal-items"></ul>
          <hr style="border-top: 1px solid #555;">
          <p>Total: <span id="cart-modal-total">0</span> Bs.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
          <button type="button" class="btn btn-primary" id="pay-button"><i class="fas fa-shopping-cart"></i> Comprar</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('styles')
<style>
  .agotado-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 0, 0, 0.5);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    z-index: 10;
  }
  
  .card {
    position: relative;
  }
  
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function mostrarProductos(categoriaId = '') {
    const productosContainer = document.getElementById('productosContainer');
    axios.get('{{ route('venta.obtenerProductos') }}', {
      params: {
        categoria: categoriaId
      }
    })
    .then(response => {
      const productos = response.data;
      productosContainer.innerHTML = ''; 

      productos.forEach(producto => {
        const imagenUrl = producto.imagen_url ? `{{ route('storage.image', ['filename' => '__filename__']) }}`.replace('__filename__', producto.imagen_url) : 'https://via.placeholder.com/300';

        const agotadoOverlay = producto.stock === 0 ? '<div class="agotado-overlay">Agotado</div>' : '';
        const productoHTML = `
          <div class="col-md-4 mb-4">
            <div class="card position-relative">
              ${agotadoOverlay}
              <img src="${imagenUrl}" class="card-img-top" alt="${producto.nombre}">
              <div class="card-body">
                <h5 class="card-title">${producto.nombre}</h5>
                <p class="card-text">${producto.descripcion}</p>
                <p><strong>Precio:</strong> ${producto.precio} Bs.</p>
                <p><strong>Stock:</strong> ${producto.stock}</p>
                <button class="btn btn-primary btn-block agregar-al-carrito" data-nombre="${producto.nombre}" data-precio="${producto.precio}" data-id="${producto.codProducto}" data-stock="${producto.stock}">Agregar al carrito</button>
              </div>
            </div>
          </div>
        `;
        productosContainer.innerHTML += productoHTML;
      });

      document.querySelectorAll('.agregar-al-carrito').forEach(btn => {
        btn.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const nombre = this.getAttribute('data-nombre');
          const precio = parseFloat(this.getAttribute('data-precio'));
          const stock = parseInt(this.getAttribute('data-stock'));
          agregarAlCarrito(id, nombre, precio, stock);
        });
      });
    });
  }

  function cargarCategorias() {
    const categoriaSelector = document.getElementById('categoriaSelector');
    axios.get('{{ route('categoria.index2') }}')
      .then(response => {
        const categorias = response.data;
        categorias.forEach(categoria => {
          const option = document.createElement('option');
          option.value = categoria.codCategoria;
          option.textContent = categoria.nombre;
          categoriaSelector.appendChild(option);
        });
      });
  }
  
  let carrito = []; 
  
  function agregarAlCarrito(id, nombre, precio, stock) {
    let itemExists = false;
    carrito.forEach(item => {
      if (item.id === id) {
        if (item.cantidad < stock) {
          item.cantidad++;
        } else {
          Swal.fire({
            icon: 'warning',
            title: 'Stock insuficiente',
            text: `No se puede agregar más de ${stock} unidades del producto "${nombre}".`,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
          });
        }
        itemExists = true;
      }
    });
  
    if (!itemExists) {
      carrito.push({ id: id, nombre: nombre, precio: precio, cantidad: 1, stock: stock });
    }
  
    actualizarInterfazCarrito();
  }
  
  function actualizarInterfazCarrito() {
    const carritoModalItems = document.getElementById('cart-modal-items');
    carritoModalItems.innerHTML = '';
    let total = 0;
  
    carrito.forEach(item => {
      const subtotal = item.precio * item.cantidad;
      
      let itemHTML = `
        <li class="cart-item">
          <div class="item-info">
            <span>${item.nombre}: ${item.cantidad} x ${item.precio.toFixed(2)} Bs. = ${subtotal.toFixed(2)} Bs.</span>
          </div>
          <div class="item-actions">
            <button class="btn btn-sm disminuir-cantidad" data-nombre="${item.nombre}"><i class="fas fa-minus"></i></button>
            <button class="btn btn-sm aumentar-cantidad" data-nombre="${item.nombre}"><i class="fas fa-plus"></i></button>
            <button class="btn btn-sm eliminar-item" data-nombre="${item.nombre}"><i class="fas fa-trash"></i></button>
          </div>
        </li>`;
      carritoModalItems.innerHTML += itemHTML;
      
      total += subtotal;
    });
  
    document.getElementById('cart-modal-total').textContent = total.toFixed(2);
    document.querySelector('.cart-badge').textContent = carrito.length; 
  }
  
  document.getElementById('cart-icon').addEventListener('click', function() {
    actualizarInterfazCarrito();
    $('#cartModal').modal('show');
  });

  $('#cartModal').on('click', '.aumentar-cantidad', function() {
    const nombre = $(this).data('nombre');
    carrito.forEach(item => {
      if (item.nombre === nombre) {
        if (item.cantidad < item.stock) {
          item.cantidad++;
        } else {
          Swal.fire({
            icon: 'warning',
            title: 'Stock insuficiente',
            text: `No se puede aumentar más de ${item.stock} unidades del producto "${nombre}".`,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
          });
        }
      }
    });
    actualizarInterfazCarrito();
  });
  
  $('#cartModal').on('click', '.disminuir-cantidad', function() {
    const nombre = $(this).data('nombre');
    carrito.forEach(item => {
      if (item.nombre === nombre && item.cantidad > 1) {
        item.cantidad--;
      }
    });
    actualizarInterfazCarrito();
  });
  
  $('#cartModal').on('click', '.eliminar-item', function() {
    const nombre = $(this).data('nombre');
    carrito = carrito.filter(item => item.nombre !== nombre);
    actualizarInterfazCarrito();
  });
  
  document.getElementById('pay-button').addEventListener('click', function() {
    // Prepara los datos del carrito para enviar en la solicitud
    const idsYCantidades = carrito.map(item => `${item.id}:${item.cantidad}`).join(',');

    if (idsYCantidades) {
        const url = `{{ route('comprar.detalle', ['idsYCantidades' => '__idsYCantidades__']) }}`.replace('__idsYCantidades__', idsYCantidades);
        console.log('Redireccionando a:', url); 
        
        window.location.href = url;
    } else {
        alert('El carrito está vacío. Añade productos antes de pagar.');
    }
  });

  document.getElementById('categoriaSelector').addEventListener('change', function() {
    mostrarProductos(this.value);
  });
  
  cargarCategorias();
  mostrarProductos();
  
  @if (session('success'))
    Swal.fire({
      icon: 'success',
      title: '¡Éxito!',
      text: '{{ session('success') }}',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Aceptar'
    });
  @endif
</script>


@endpush

