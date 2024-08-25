<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Ejecuta las semillas de la base de datos.
     *
     * @return void
     */
    public function run(): void
    {
        $menusVendedor = [
            ['nombre' => 'Inicio', 'url' => '/inicio/estadistica', 'icono' => 'fas fa-home', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Cliente', 'url' => '/cliente/index', 'icono' => 'fas fa-users', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Pago', 'url' => '/pago/index', 'icono' => 'fas fa-chart-pie', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Membresia', 'url' => '/membresia/index', 'icono' => 'fas fa-code', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Categorias', 'url' => '/categoria/index', 'icono' => 'fas fa-box', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Producto', 'url' => '/producto/index', 'icono' => 'fas fa-box', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Proveedor', 'url' => '/proveedor/index', 'icono' => 'fas fa-truck', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Compra', 'url' => '/compra/index', 'icono' => 'fas fa-shopping-cart', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Venta', 'url' => '/compra/index', 'icono' => 'fas fa-shopping-cart', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Horario', 'url' => '/horario/index', 'icono' => 'fas fa-box', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Servicio', 'url' => '/servicio/index', 'icono' => 'fas fa-box', 'codTipoUsuarioF' => 2, 'padreId' => null],
            ['nombre' => 'Gestionar Precios de Servicio', 'url' => '/precioServicio/index', 'icono' => 'fas fa-dollar-sign', 'codTipoUsuarioF' => 2, 'padreId' => null],
        ];

        $menusAdministrador = [
            ['nombre' => 'Inicio', 'url' => '/estadisticas/index', 'icono' => 'fas fa-home', 'codTipoUsuarioF' => 3, 'padreId' => null],
            ['nombre' => 'Gestionar Encargado', 'url' => '/vendedor/index', 'icono' => 'fas fa-chart-line', 'codTipoUsuarioF' => 3, 'padreId' => null],
            ['nombre' => 'Gestionar Tipos de Usuario', 'url' => '/tipoUsuario/index', 'icono' => 'fas fa-chart-pie', 'codTipoUsuarioF' => 3, 'padreId' => null],
            ['nombre' => 'Gestionar Usuarios', 'url' => '/usuario/index', 'icono' => 'fas fa-chart-pie', 'codTipoUsuarioF' => 3, 'padreId' => null],
            ['nombre' => 'Generar Reporte Compra', 'url' => '/reporte/index1', 'icono' => 'fas fa-file-alt', 'codTipoUsuarioF' => 3, 'padreId' => null],
            ['nombre' => 'Generar Reporte Venta', 'url' => '/reporte/index2', 'icono' => 'fas fa-file-alt', 'codTipoUsuarioF' => 3, 'padreId' => null],
        ];

        $menusCliente = [
      
        ];

        // Inserta los datos en la base de datos
        DB::table('Menu')->insert($menusVendedor);
        DB::table('Menu')->insert($menusAdministrador);
        // DB::table('Menu')->insert($menusCliente); 
    }
}
