<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ get_title($title ?? '') }} </title>

        <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
        
        <!-- Section PWA -->
        @include('layouts.partials.meta')

        @livewireStyles
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <ul class="navbar-nav bg_color sidebar sidebar-dark accordion" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <img class="img-profile rounded-circle" src="images/icon-72x72.png" alt="logo">
                    </div>

                    <div class="sidebar-brand-text mx-3"> {{ config('app.name') }} </div>
                </a>
    
                <hr class="sidebar-divider my-0">
    
                <li class="nav-item {{ $title == 'Dashboard' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <span> Accueil </span>
                    </a>
                </li>
    
                <hr class="sidebar-divider">
    
                <div class="sidebar-heading">
                    {{ __("Patients et utilisateurs") }}
                </div>
    
                <li class="nav-item {{ $title == 'Liste des patients' ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-users "></i>
                        <span> {{ __("Patients") }} </span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header"> {{ __("Options") }} </h6>
                            <a class="collapse-item" href="{{ route('patient.index') }}"> {{ __("Liste des patients") }} </a>
                            <a class="collapse-item" href="{{ route('patient.create') }}"> {{ __("Ajouter un patient") }} </a>
                        </div>
                    </div>
                </li>
    
                <li class="nav-item {{ $title == 'Liste des utilisateurs' ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
                        aria-expanded="true" aria-controls="collapseUsers">
                        <i class="fas fa-users"></i>
                        <span> {{ __("Utilisateurs") }} </span>
                    </a>
                    <div id="collapseUsers" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header"> {{ __("Options") }} </h6>
                            <a class="collapse-item" href="{{ route('list_user') }}"> {{ __("Liste des utilisateurs") }} </a>
                        </div>
                    </div>
                </li>
    
                <hr class="sidebar-divider">
    
                <div class="sidebar-heading">
                    {{ __("Paramètres") }} 
                </div>
    
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVacine"
                        aria-expanded="true" aria-controls="collapseVacine">
                        <i class="fas fa-syringe"></i>
                        <span> {{ __("Vaccination") }} </span>
                    </a>
                    <div id="collapseVacine" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header"> {{ __("Options") }} </h6>
                            <a class="collapse-item" href="{{ route('calendar.index') }}"> {{ __("Calendrier des vaccinations") }} </a>
                            <a class="collapse-item" href="{{ route('calendar.create') }}"> {{ __("Ajouter un vaccin") }} </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item {{ $title == 'Réglages' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('setings') }}">
                        <i class="fas fa-tools"></i>
                        <span> {{ __("Réglages") }} </span>
                    </a>
                </li>
    
                <hr class="sidebar-divider d-none d-md-block">
    
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            </ul>
            
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
    
                        <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                    aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form> -->
    
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow d-sm-none">
                                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search fa-fw"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                    aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto w-100 navbar-search">
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-light border-0 small"
                                                placeholder="Search for..." aria-label="Search"
                                                aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
    
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> {{ Auth::user()->name }} </span>
                                    <img class="img-profile rounded-circle" src="images/icon-72x72.png">
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ __("Mon profile") }}
                                    </a>
                                    
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ __("Déconnexion") }}
                                    </a>
                                </div>
                            </li>
    
                        </ul>
    
                    </nav>
                    
                    <div id="error_network"></div>
                   
                    <div class="container-fluid">
                        @yield('main_content')
                    </div>    
                </div>
                
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span> © Copyright {{ Date('Y') }} Africasys - All Rights Reserved </span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Confirmer </h5>
                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center"> Etes vous sûr de vouloir vous deconnecter? </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        
                        <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Déconnexion') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/bootstrap.js') }}"></script>
    
        <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    
        <script src="{{ asset('js/Chart.min.js') }}"></script>

        <script src="{{ asset('js/register_sw.js') }}"></script>
    
        @livewireScripts
        @yield('script')
    </body>
</html>