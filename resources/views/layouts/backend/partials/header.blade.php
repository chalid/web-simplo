<div class="header">
    <!-- navbar -->
    <div class="navbar-custom navbar navbar-expand-lg">
        <div class="container-fluid px-0">
            <a class="navbar-brand d-block d-md-none" href="{{ url('/') }}">
                <img src="{{ asset('assets/backend/images/svg/logo.svg') }}" width="80px" height="30px" alt="{{ config('app.name', 'Laravel') }}">
            </a>
            <a id="nav-toggle" href="#!" class="ms-auto ms-md-0 me-0 me-lg-3 ">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-text-indent-left text-muted" viewbox="0 0 16 16">
                    <path d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
                </svg>
            </a>
            <div class="d-none d-md-none d-lg-block">  
            </div>
            <!--Navbar nav -->
            <ul class="navbar-nav navbar-right-wrap ms-lg-auto d-flex nav-top-wrap align-items-center ms-4 ms-lg-0">
                <a href="#" class="form-check form-switch theme-switch btn btn-ghost btn-icon rounded-circle mb-0 ">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                </a>
                <!-- List -->
                <li class="dropdown ms-2">
                    <a class="rounded-circle" href="#!" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-md avatar-indicators avatar-online">
                            @if(Auth::user()->avatar)
                            <img alt="avatar" src="{{ asset('storage/upload_files/images/avatar/avatar/' . Auth::user()->avatar) }}" class="rounded-circle">
                            @else
                            <img alt="avatar" src="{{ asset('assets/backend/images/avatar/avatar-11.jpg') }}" class="rounded-circle">
                            @endif
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                        <div class="px-4 pb-0 pt-2">
                            <div class="lh-1 ">
                                <h5 class="mb-1"> {{ Auth::user()->name }}</h5>
                                <a href="#!" class="text-inherit fs-6">View my profile</a>
                            </div>
                            <div class=" dropdown-divider mt-3 mb-2"></div>
                        </div>
                        <ul class="list-unstyled">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('home.change_avatar') }}">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>
                                    Edit Avatar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('home.change_password') }}">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="settings"></i>Change Password
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>
                                    {{ __('Sign Out') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>