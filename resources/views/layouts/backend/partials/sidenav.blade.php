<!-- navbar vertical -->
<!-- Sidebar -->
<div class="navbar-vertical navbar nav-dashboard">
    <div class="h-100" data-simplebar="">
        <!-- Brand logo -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/backend/images/svg/logo.svg') }}" width="80px" height="30px" alt="{{ config('app.name', 'Laravel') }}">
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}" >
                    <i data-feather="home" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('Dashboard') }}
                </a>
            </li>
            <!-- Nav Apps -->
            <li class="nav-item">
                <div class="navbar-heading">{{ __('Website') }}</div>
            </li>
            @can('About Us')
            <li class="nav-item">
                <a class="nav-link has-arrow " href="{{ route('about') }}">
                    <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('About Us') }}
                </a>
            </li>
            @endcan
            @can('Article')
            <li class="nav-item">
                <a class="nav-link has-arrow " href="{{ route('article') }}">
                    <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('Article') }}
                </a>
            </li>
            @endcan
            @can('Banner')
            <li class="nav-item">
                <a class="nav-link has-arrow " href="{{ route('banner') }}">
                    <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('Banner') }}
                </a>
            </li>
            @endcan
            @can('Brand')
            <li class="nav-item">
                <a class="nav-link has-arrow " href="{{ route('brand') }}">
                    <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('Brand') }}
                </a>
            </li>
            @endcan
            @can('Customer')
            <li class="nav-item">
                <a class="nav-link has-arrow " href="{{ route('customer') }}">
                    <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('Customer') }}
                </a>
            </li>
            @endcan
            @can('Product')
            <li class="nav-item">
                <a class="nav-link has-arrow " href="{{ route('product') }}">
                    <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('Product') }}
                </a>
            </li>
            @endcan
            @can('Study Case')
            <li class="nav-item">
                <a class="nav-link has-arrow " href="{{ route('study-case') }}">
                    <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('Study Case') }}
                </a>
            </li>
            @endcan
            @can('Faq')
            <li class="nav-item">
                <a class="nav-link has-arrow " href="{{ route('faq') }}">
                    <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                    {{ __('Faq') }}
                </a>
            </li>
            @endcan
            <!-- Nav Settings -->
            @can('Can menu setting')
                <li class="nav-item">
                    <div class="navbar-heading">{{ __('Settings') }}</div>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow " href="{{ route('product-category') }}">
                        <i data-feather="archive" class="nav-icon me-2 icon-xxs"></i>
                        {{ __('Product Category') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow " href="{{ route('faq-category') }}">
                        <i data-feather="clipboard" class="nav-icon me-2 icon-xxs"></i>
                        {{ __('FAQ Category') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link has-arrow " href="{{ route('article-category') }}">
                        <i data-feather="book" class="nav-icon me-2 icon-xxs"></i>
                        {{ __('Article Category') }}
                    </a>
                </li>
                @can('User')
                    <li class="nav-item">
                        <a class="nav-link has-arrow " href="{{ route('user') }}">
                            <i data-feather="user" class="nav-icon me-2 icon-xxs"></i>
                            {{ __('User') }}
                        </a>
                    </li>
                @endcan
                @can('Role')
                    <li class="nav-item">
                        <a class="nav-link has-arrow " href="{{ route('role') }}">
                            <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                            {{ __('Role') }}
                        </a>
                    </li>
                @endcan
                @can('Permission')
                    <li class="nav-item">
                        <a class="nav-link has-arrow " href="{{ route('permission') }}">
                            <i data-feather="lock" class="nav-icon me-2 icon-xxs"></i>
                            {{ __('Permission') }}
                        </a>
                    </li>
                @endcan
                @can('Sysparam')
                    <li class="nav-item">
                        <a class="nav-link has-arrow " href="{{ route('sysparam') }}">
                            <i data-feather="list" class="nav-icon me-2 icon-xxs"></i>
                            {{ __('Sysparam') }}
                        </a>
                    </li>
                @endcan
            @endcan
        </ul>
    </div>
</div>