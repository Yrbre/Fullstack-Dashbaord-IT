<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex ">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="#">

                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120"
                    xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
                {{-- <i class="fe fe-monitor"></i><br>
                <span class="text-base">Information Technology</span> --}}
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
                <a href="#" data-toggle="collapse" aria-expanded="false" class="nav-link">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
                </a>
            </li>
        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Main</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
                <a href="#" data-toggle="collapse" aria-expanded="false" class="nav-link">
                    <i class="fe fe-box fe-16"></i>
                    <span class="ml-3 item-text">Tasks</span>
                </a>
                {{-- <ul class="collapse list-unstyled pl-4 w-100" id="ui-elements">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./ui-color.html"><span class="ml-1 item-text">Colors</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./ui-typograpy.html"><span
                                class="ml-1 item-text">Typograpy</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./ui-icons.html"><span class="ml-1 item-text">Icons</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./ui-buttons.html"><span
                                class="ml-1 item-text">Buttons</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./ui-notification.html"><span
                                class="ml-1 item-text">Notifications</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./ui-modals.html"><span class="ml-1 item-text">Modals</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./ui-tabs-accordion.html"><span class="ml-1 item-text">Tabs &
                                Accordion</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="./ui-progress.html"><span
                                class="ml-1 item-text">Progress</span></a>
                    </li>
                </ul> --}}
            </li>
            <li class="nav-item w-100">
                <a class="nav-link @yield('menuactivity')" href="{{ route('activity.index') }}">
                    <i class="fe fe-activity fe-16"></i>
                    <span class="ml-3 item-text">Activity</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link" href="#">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-3 item-text">Activity History</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link @yield('menucategory')" href="{{ route('category.index') }}">
                    <i class="fe fe-grid fe-16"></i>
                    <span class="ml-3 item-text">Category</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link" href="#">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">End User</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link @yield('menulocation')" href="{{ route('location.index') }}">
                    <i class="fe fe-map-pin fe-16"></i>
                    <span class="ml-3 item-text">Location</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link" href="#">
                    <i class="fe fe-user fe-16"></i>
                    <span class="ml-3 item-text">User</span>
                </a>
            </li>
        </ul>

    </nav>
</aside>
