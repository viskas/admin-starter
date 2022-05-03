<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

    <!-- Nav Item - Alerts -->
    {{--                    <li class="nav-item dropdown no-arrow mx-1">--}}
    {{--                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
    {{--                            <i class="fas fa-bell fa-fw"></i>--}}
    {{--                            <!-- Counter - Alerts -->--}}
    {{--                            <span class="badge badge-danger badge-counter">3+</span>--}}
    {{--                        </a>--}}
    {{--                        <!-- Dropdown - Alerts -->--}}
    {{--                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">--}}
    {{--                            <h6 class="dropdown-header">--}}
    {{--                                Alerts Center--}}
    {{--                            </h6>--}}
    {{--                            <a class="dropdown-item d-flex align-items-center" href="#">--}}
    {{--                                <div class="mr-3">--}}
    {{--                                    <div class="icon-circle bg-primary">--}}
    {{--                                        <i class="fas fa-file-alt text-white"></i>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                                <div>--}}
    {{--                                    <div class="small text-gray-500">December 12, 2019</div>--}}
    {{--                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>--}}
    {{--                                </div>--}}
    {{--                            </a>--}}
    {{--                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>--}}
    {{--                        </div>--}}
    {{--                    </li>--}}

        @if (count(config('laravellocalization.supportedLocales')) > 0)
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle text-gray-600" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-globe fa-fw" style="margin-right: 5px"></i> {{ strtoupper(App::getLocale()) }}
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown" style="width: 5%!important">
                    @foreach (config('laravellocalization.supportedLocales') as $key => $locale)
                        <a class="dropdown-item d-flex align-items-center" href="{{ LaravelLocalization::getLocalizedURL($key) }}" style="font-size: 13px">
                            {{ strtoupper($key) }} | {{ mb_strtoupper($locale['native']) }}
                        </a>
                    @endforeach
                </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
        @endif

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                @if(Auth::user()->avatar)
                    <img class="img-profile rounded-circle avatar cover-img" src="{{ asset('storage/avatars/'.Auth::user()->id.'/'.Auth::user()->avatar)}}">
                @else
                    <img class="img-profile rounded-circle avatar font-weight-bold" src="https://ui-avatars.com/api/?background=466cd9&color=fff&font-size=0.4&bold=true&name={{ mb_strtoupper(Auth::user()->name).'+'.mb_strtoupper(Auth::user()->last_name) }}" alt="">
                @endif
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @can('view profile')
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                        <i class="fas fa-address-card fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Profile') }}
                    </a>
                @endcan

                @can('view sessions')
                    <a class="dropdown-item" href="{{ route('admin.sessions.index') }}">
                        <i class="fas fa-history fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Sessions') }}
                    </a>
                    <div class="dropdown-divider"></div>
                @endcan

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    {{ __('Logout') }}
                </a>
            </div>
        </li>
    </ul>
</nav>
