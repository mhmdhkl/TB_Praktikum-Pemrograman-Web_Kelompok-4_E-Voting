<!DOCTYPE html>
<html lang="en">

<x-header>{{ $title }}</x-header>

<head>
    <style>
        .sidebar {
            background-color: #b30000; 
        }

        .sidebar .nav-link {
            color: #ffffff; 
        }

        .sidebar .nav-link:hover {
            background-color: #ff4d4d; 
        }

        .sidebar .sidebar-heading {
            color: #ffcccc; 
        }

        #sidebarToggle {
            background-color: #ff6666; 
        }

        #sidebarToggle:hover {
            background-color: #cc0000; 
        }
        .sidebar-brand-icon img {
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <div class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard"
                aria-label="E-Voting Dashboard">
                <div class="sidebar-brand-icon">
                <img src="{{ asset('storage/logo/logo.png') }}" alt="E-Voting Logo" style="width: 50px; height: auto;">
                </div>
                <div class="sidebar-brand-text mx-3 text-white">E-Voting</div>
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <ul class="nav flex-column">
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard">
                        <i class="fas fa-fw fa-chart-area fa-lg"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
            </ul>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                User Data
            </div>

            <!-- Nav Item - Candidates -->
            <li class="nav-item {{ request()->is('candidate') ? 'active' : '' }}">
                <a class="nav-link" href="/candidate">
                    <i class="fas fa-users fa-lg"></i>
                    <span class="sidebar-text">Kandidat</span>
                </a>
            </li>

            <!-- Nav Item - Voter -->
            <li class="nav-item {{ request()->is('voters') ? 'active' : '' }}">
                <a class="nav-link" href="/voters">
                    <i class="fas fa-person-booth fa-lg"></i>
                    <span class="sidebar-text">Pemberi Suara</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manage
            </div>

            <!-- Nav Item - Admin -->
            <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-user-lock fa-lg"></i>
                    <span class="sidebar-text">Admin</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <x-topbar></x-topbar>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <x-footer></x-footer>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

</body>

</html>
