<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">APP</div>
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Escritorio
                </a>

                @permission('clientes')
                <a class="nav-link" href="{{ route('clients.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users-line"></i></div>
                    Clientes
                </a>
                @endpermission

                @permission('compras')
                <a class="nav-link" href="{{ route('compras.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    Compras
                </a>
                @endpermission

                @permission('ventas')

                <a class="nav-link" href="{{ route('clients.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-money-check-dollar"></i></div>
                    Ventas
                </a>

                @endpermission

                @permission('inventario')
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInventario" aria-expanded="false" aria-controls="collapseInventario">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-warehouse"></i></div>
                    Inventario
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <!-- Inventario Submenu -->
                <div class="collapse" id="collapseInventario" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('productos.index') }}">
                            <i class="fa-solid fa-box" 0></i> Productos
                        </a>
                        <a class="nav-link" href="{{ route('categorias.index') }}">
                            <i class="fa-solid fa-tag"></i> Categorías
                        </a>
                        <a class="nav-link" href="">
                            <i class="fa-solid fa-boxes-stacked"></i> Stock
                        </a>
                    </nav>
                </div>
                @endpermission




                @permission('tareas')
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-list-check"></i></div>
                    Tareas
                </a>
                @endpermission

                @permission('calendario')
                <a class="nav-link" href="{{ route('calendar') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-days"></i></div>
                    Calendario
                </a>
                @endpermission

                <div class="sb-sidenav-menu-heading">Administración</div>

                @permission('configuracion')
                <a class="nav-link" href="{{ route('settings.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                    Configuración
                </a>
                @endpermission

                @permission('usuarios')
                <a class="nav-link" href="{{ route('users.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users-gear"></i></div>
                    Usuarios
                </a>
                @endpermission

                @permission('permisos')
                <a class="nav-link" href="{{ route('permissions.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user-shield"></i></div>
                    Permisos
                </a>
                @endpermission

            </div>
        </div>
    </nav>
</div>