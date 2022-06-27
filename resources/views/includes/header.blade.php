<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $description }}">
    <meta name="author" content="{{ $author }}">

    <title>{{ ucfirst($name) }} : {{ $title }}</title>

    <link href="{{ asset('assets/css/app.css')}}" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="manifest" href="/manifest.json">
    <link rel="manifest" href="/mix-manifest.json">
    @yield('header')
</head>

<body>
@include('includes.sidebar')
<div class="main">
    <nav class="navbar navbar-expand navbar-light bg-white sticky-top">
        <a class="sidebar-toggle d-flex mr-3 text-dark">
            <i class="fas fa-bars fa-lg"></i>
        </a>



        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-icon dropdown-toggle ml-2 d-inline-block d-sm-none" href="#" id="userDropdown" data-toggle="dropdown">
                        <div class="position-relative">
                            <i class="align-middle mt-n1" data-feather="settings"></i>
                        </div>
                    </a>
                    <a class="nav-link nav-link-user dropdown-toggle d-none d-sm-inline-block" href="#" id="userDropdown" data-toggle="dropdown">
                        <img src="{{ asset('assets/img/avatar.png') }}" class="avatar img-fluid rounded-circle mr-1" alt="Avatar " />
                        <span class="text-dark">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">{{ __('Sign out') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>



            </ul>
        </div>
    </nav>

