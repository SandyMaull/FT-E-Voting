<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/administrator') }}" class="brand-link">
        {{-- <img src="{{ asset('img/hokusei-logo-fix.png') }}" alt="E-Voting" class="brand-image img-circle elevation-3"
            style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">E-Voting Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin_asset/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a id="dashboard" href="{{ url('administrator') }}" class="nav-link">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li id="datavoting" class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs nav-icon"></i>
                        <p>Voting<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a id="datavoting_voting" href="{{ url('administrator/voting') }}" class="nav-link">
                                <i class="fas fa-vote-yea"></i>
                                <p>Data Voting</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="datavoting_kandidat" href="{{ url('administrator/kandidat') }}" class="nav-link">
                                <i class="fas fa-user-friends"></i>
                                <p>Data Kandidat</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li id="datavoters" class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Data Voters<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a id="datavoters_notverified" href="{{ url('/admin/voters/unverif') }}" class="nav-link">
                            <i class="fas fa-user-times nav-icon"></i>
                            <p>Belum Terverifikasi</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a id="datavoters_verified" href="{{ url('/admin/voters/verif') }}" class="nav-link">
                            <i class="fas fa-user-check nav-icon"></i>
                            <p>Terverifikasi</p>
                        </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
