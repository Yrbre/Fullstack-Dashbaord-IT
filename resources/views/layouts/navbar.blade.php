<div class="wrapper">
    <nav class="topnav navbar navbar-light d-flex align-items-center justify-content-between">

        <!-- LEFT : Toggle Sidebar -->
        <div class="d-flex align-items-center">
            <button type="button" class="navbar-toggler text-muted collapseSidebar">
                <i class="fe fe-menu"></i>
            </button>
        </div>

        <!-- CENTER : Title -->
        <div class="text-center flex-grow-1">
            <label class="text-white m-0">@yield('judul')</label>
        </div>

        <!-- RIGHT : Avatar -->
        <div class="d-flex align-items-center">
            <ul class="nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-muted" href="#"
                        id="navbarDropdownMenuLink" role="button" data-toggle="dropdown">

                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('dark/assets/avatars/face-1.jpg') }}"
                            class="rounded-circle mr-2" width="35" height="35">

                        <span>{{ Auth::user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('profileNew.edit', Auth::user()->id) }}">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>

    </nav>
</div>
