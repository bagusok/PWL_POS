@php
    $user = auth()->user();

    $menus = [
        [
            'title' => 'Dashboard',
            'url' => '/',
            'icon' => 'fas fa-tachometer-alt',
            'menu' => 'dashboard',
            'roles' => ['ADM', 'MNG', 'STF'],
        ],
        [
            'header' => 'Data Pengguna',
        ],
        [
            'title' => 'Level User',
            'url' => '/level',
            'icon' => 'fas fa-layer-group',
            'menu' => 'level',
            'roles' => ['ADM'],
        ],
        [
            'title' => 'Data User',
            'url' => '/user',
            'icon' => 'far fa-user',
            'menu' => 'user',
            'roles' => ['ADM'],
        ],
        [
            'header' => 'Supplier',
        ],
        [
            'title' => 'Data Supplier',
            'url' => '/supplier',
            'icon' => 'fas fa-user',
            'menu' => 'level',
            'roles' => ['ADM', 'MNG'],
        ],
        [
            'header' => 'Data Barang',
        ],
        [
            'title' => 'Kategori Barang',
            'url' => '/kategori',
            'icon' => 'far fa-bookmark',
            'menu' => 'kategori',
            'roles' => ['ADM', 'MNG', 'STF'],
        ],
        [
            'title' => 'Data Barang',
            'url' => '/barang',
            'icon' => 'far fa-list-alt',
            'menu' => 'barang',
            'roles' => ['ADM', 'MNG', 'STF'],
        ],
        [
            'header' => 'Transaksi',
        ],
        [
            'title' => 'Stok Barang',
            'url' => '/stock',
            'icon' => 'fas fa-cubes',
            'menu' => 'stock',
            'roles' => ['ADM', 'MNG', 'STF'],
        ],
        [
            'title' => 'Transaksi Penjualan',
            'url' => '/penjualan',
            'icon' => 'fas fa-cash-register',
            'menu' => 'penjualan',
            'roles' => ['ADM', 'MNG', 'STF'],
        ],
        [
            'header' => 'Settings',
        ],
        [
            'title' => 'Ganti Foto Profile',
            'url' => 'user/settings/change-profile-picture',
            'icon' => 'fas fa-cubes',
            'menu' => 'change_profile_picture',
            'roles' => ['ADM', 'MNG', 'STF'],
        ],
    ];
@endphp

<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @foreach ($menus as $menu)
                @if (isset($menu['header']))
                    <li class="nav-header">{{ $menu['header'] }}</li>
                @elseif (isset($menu['title']) && in_array($user->level->level_kode, $menu['roles']))
                    <li class="nav-item">
                        <a href="{{ url($menu['url']) }}"
                            class="nav-link {{ $activeMenu == $menu['menu'] ? 'active' : '' }}">
                            <i class="nav-icon {{ $menu['icon'] }}"></i>
                            <p>{{ $menu['title'] }}</p>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
        @auth
            <button id="btn-logout" type="button" class="btn btn-danger btn-sm">Logout</button>
        @endauth
    </nav>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('#btn-logout').click(function() {
                console.log('logout');

                $.ajax({
                    url: '{{ url('logout') }}',
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        window.location.href = '{{ url('login') }}';
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endpush
