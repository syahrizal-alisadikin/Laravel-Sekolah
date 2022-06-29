<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">SMK INDONESIA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SMK</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">MAIN MENU</li>
            <li class="{{ setActive('admin/dashboard') }}"><a class="nav-link"
                    href="{{ route('admin.dashboard.index') }}"><i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span></a></li>
           

            

            

            
            <li
                class="dropdown {{ setActive('admin/post'). setActive('admin/tag'). setActive('admin/category') }}">
                {{-- @if(auth()->user()->can('tags.index') || auth()->user()->can('post.index') || auth()->user()->can('categories.index')) --}}
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-info"></i><span>Info
                    </span></a>
                {{-- @endif --}}
                
                <ul class="dropdown-menu">
                    {{-- @can('tags.index') --}}
                        <li class="{{ setActive('admin/tag') }}"><a class="nav-link" href="{{ route('admin.tag.index') }}"><i class="fas fa-tags"></i> <span>Tags</span></a>
                        </li>
                    {{-- @endcan --}}
                   

                    {{-- @can('categories.index') --}}
                        <li class="{{ setActive('admin/category') }}"><a class="nav-link" href="{{ route('admin.category.index') }}"><i class="fas fa-folder"></i>
                        <span>Kategori</span></a>
                        </li>
                    {{-- @endcan --}}

                    {{-- @can('posts.index') --}}
                        <li class="{{ setActive('admin/post') }}"><a class="nav-link" href="{{ route('admin.post.index') }}
                        "><i class="fas fa-book-open"></i>
                        <span>Berita</span></a></li>
                    {{-- @endcan --}}
                </ul>
            </li>
            {{-- @can('events.index') --}}
                <li class="{{ setActive('admin/event') }}"><a class="nav-link" href="{{ route('admin.event.index') }}"><i class="fas fa-bell"></i>
            <span>Agenda</span></a></li>
            {{-- @endcan --}}

            {{-- @if(auth()->user()->can('photos.index') || auth()->user()->can('videos.index') || auth()->user()->can('sliders.index') ) --}}
            <li class="menu-header">GALERI</li>
            {{-- @endif --}}
            
            {{-- @can('sliders.index') --}}
            <li class="{{ setActive('admin/slider') }}"><a class="nav-link"
                    href="{{ route('admin.slider.index') }}"><i class="fas fa-laptop"></i>
                    <span>Sliders</span></a></li>
            {{-- @endcan --}}
            {{-- @can('photos.index') --}}
            <li class="{{ setActive('admin/photo') }}"><a class="nav-link"
                    href="{{ route('admin.photo.index') }}"><i class="fas fa-image"></i>
                    <span>Foto</span></a></li>
            {{-- @endcan --}}

            {{-- @can('videos.index') --}}
            <li class="{{ setActive('admin/video') }}"><a class="nav-link"
                    href="{{ route('admin.video.index') }}"><i class="fas fa-video"></i>
                    <span>Video</span></a></li>
            {{-- @endcan --}}

            {{-- @if(auth()->user()->can('roles.index') || auth()->user()->can('permission.index') || auth()->user()->can('users.index')) --}}
            <li class="menu-header">PENGATURAN</li>
            {{-- @endif --}}
            
            {{-- @can('siswa.index') --}}
            <li class="{{ setActive('admin/kelas') }}"><a class="nav-link"
                href="{{ route('admin.kelas.index') }}"><i class="fas fa-hotel"></i>
                <span>Kelas</span></a></li>
            {{-- @endcan --}}

            {{-- @can('siswa.index') --}}
            <li class="{{ setActive('admin/siswa') }}"><a class="nav-link"
                    href="{{ route('admin.siswa.index') }}"><i class="fas fa-users"></i>
                    <span>Siswa</span></a></li>
            {{-- @endcan --}}
             {{-- @can('siswa.index') --}}
             <li class="{{ setActive('admin/transactions') }}"><a class="nav-link"
                href="{{ route('admin.transactions.index') }}"><i class="fas fa-dollar-sign"></i>
                <span>Transaksi</span></a></li>
                <li class="{{ setActive('admin/pembayaran') }}"><a class="nav-link"
                    href="{{ route('admin.pembayaran.index') }}"><i class="fas fa-dollar-sign"></i>
                    <span>Pembayaran</span></a></li>
        {{-- @endcan --}}
        <li class="{{ setActive('admin/user') }}"><a class="nav-link"
            href="{{ route('admin.user.index') }}"><i class="fas fa-user"></i>
            <span>Admin</span></a></li>
            {{-- <li
                class="dropdown {{ setActive('admin/role'). setActive('admin/permission'). setActive('admin/user') }}">
                @if(auth()->user()->can('roles.index') || auth()->user()->can('permission.index') || auth()->user()->can('users.index'))
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Users
                    Management</span></a>
                @endif
                
                <ul class="dropdown-menu">
                    @can('roles.index')
                        <li class="{{ setActive('admin/role') }}"><a class="nav-link"
                            href="{{ route('admin.role.index') }}"><i class="fas fa-unlock"></i> Roles</a>
                    </li>
                    @endcan
                   

                    @can('permissions.index')
                        <li class="{{ setActive('admin/permission') }}"><a class="nav-link"
                        href="#"><i class="fas fa-key"></i>
                        Permissions</a></li>
                    @endcan

                    @can('users.index')
                        <li class="{{ setActive('admin/user') }}"><a class="nav-link"
                         href="{{ route('admin.user.index') }}"><i class="fas fa-users"></i> Users</a>
                        </li>
                    @endcan
                </ul>
            </li> --}}
        </ul>
    </aside>
</div>