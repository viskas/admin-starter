<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" />
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-custom.css') }}" rel="stylesheet">
    @yield('additional-css')

    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
</head>
<body id="page-top">
    <div id="wrapper">
        @include('layouts.partials.admin.menu')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.partials.admin.topbar')

                <div class="container-fluid">
                    @if(Session::has('impersonation'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info" role="alert">
                                    <h5 class="alert-heading">
                                        <span class="fas fa-user"></span> {{ __('You are logged in as a user :user', ['user' => Auth::user()->email]) }}
                                    </h5>
                                    <p class="mb-0">{{ __('To return to your account, click on') }} <a href="{{ route('admin.impersonate.logout') }}">{{ __('Logout') }}</a></p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('main-content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('layouts.partials.admin.logoutModal')
    @include('layouts.partials.admin.script')
</body>
</html>
