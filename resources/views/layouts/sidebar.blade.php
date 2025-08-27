<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ url('/home') }}"><img src="{{ asset('stisla/assets/img/Logo.jpg') }}" alt="logo" width="50%"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('/home') }}"></a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header" style="color: #1a8683">Menú</li>
      @if (Auth::check() && Auth::user()->role)
        @if (Auth::user()->role->nombre === 'Administrador')
          <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> <span>Usuarios</span></a>
          </li>
          <li class="{{ request()->is('admin/clientes*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.clientes.index') }}">
              <i class="fas fa-address-book"></i> <span>Clientes</span>
            </a>
          </li>
          <li class="{{ request()->is('admin/cajas*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.cajas.index') }}">
              <i class="fas fa-box"></i> <span>Cajas</span>
            </a>
          </li>
          <li class="{{ request()->is('admin/almacenes*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.almacenes.index') }}">
              <i class="fas fa-store"></i> <span>Almacenes</span>
            </a>
          </li>
          <li class="{{ request()->is('admin/movimientos*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.movimientos.index') }}">
              <i class="fas fa-arrow-down"></i> <span>Movimientos</span>
            </a>    
          </li>
          <li class="{{ request()->is('admin/categorias*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.categorias.index') }}">
              <i class="fas fa-tags"></i> <span>Categorías</span>
            </a>
          </li>
          <li class="{{ request()->is('admin/partes*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.partes.index') }}">
              <i class="fas fa-puzzle-piece"></i> <span>Partes</span>
            </a>
          </li>
          <li class="{{ request()->is('admin/inventario*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.inventario.index') }}">
              <i class="fas fa-warehouse"></i> <span>Inventario</span>
            </a>
          </li>
        @endif
      @endif
    </ul>
  </aside>
</div>