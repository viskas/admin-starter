<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('site') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
    </a>

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ Nav::isRoute('admin.home') }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span>
        </a>
    </li>

    @can('view users')
        <li class="nav-item {{ Nav::isRoute('admin.users.*') }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>{{ __('Users') }}</span>
            </a>
        </li>
    @endcan

    @can('view roles')
        <li class="nav-item {{ Nav::isRoute('admin.role.*') }}">
            <a class="nav-link" href="{{ route('admin.role.index') }}">
                <i class="fas fa-fw fa-lock"></i>
                <span>{{ __('Roles') }}</span>
            </a>
        </li>
    @endcan

    @can('view news')
        <li class="nav-item {{ Nav::isRoute('admin.news.*') }}">
            <a class="nav-link" href="{{ route('admin.news.index') }}">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>{{ __('News') }}</span>
            </a>
        </li>
    @endcan

    <li class="nav-item {{ Nav::isRoute('admin.translations.*') }}">
        <a class="nav-link" href="{{ route('admin.translations.index') }}">
            <i class="fas fa-fw fa-language"></i>
            <span>{{ __('Translations') }}</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        {{ __('Settings') }}
    </div>

    @can('view profile')
        <li class="nav-item {{ Nav::isRoute('admin.profile.*') }}">
            <a class="nav-link" href="{{ route('admin.profile.index') }}">
                <i class="fas fa-fw fa-address-card"></i>
                <span>{{ __('Profile') }}</span>
            </a>
        </li>
    @endcan

    @can('view system settings')
        <li class="nav-item {{ Nav::isRoute('admin.systemSettings.*') }}">
            <a class="nav-link" href="{{ route('admin.systemSettings.index') }}">
                <i class="fas fa-fw fa-cogs"></i>
                <span>{{ __('System settings') }}</span>
            </a>
        </li>
    @endcan

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
