<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/img/profile.webp')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    {{-- <a href="{{ route('members') }}" class="nav-link"> --}}
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Anggota
                            </p>
                        </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        {{-- <a href="{{ route('books') }}" class="nav-link"> --}}
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Buku
                            </p>
                        </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        {{-- <a href="{{ route('transactions') }}" class="nav-link"> --}}
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>
                                Peminjaman
                            </p>
                        </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        {{-- <a href="{{ route('history') }}" class="nav-link"> --}}
                            <i class="nav-icon fas fa-history"></i>
                            <p>
                                Histori
                            </p>
                        </a>
                </li>

                @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Kelola Pengguna
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
                {{-- Logout system --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>