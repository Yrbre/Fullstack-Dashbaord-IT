<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex ">
            <?php if(Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT'])): ?>
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center"
                    href="<?php echo e(route('dashboard_management.index')); ?>">
                    <svg version="1.1" id="logo" class="navbar-brand-img brand-sm"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 120 120" xml:space="preserve">
                        <g>
                            <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                            <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                            <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                        </g>
                    </svg>
                </a>
            <?php elseif(Auth::check() && in_array(Auth::user()->role, ['OPERATOR'])): ?>
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center"
                    href="<?php echo e(route('dashboard_operator.index')); ?>">
                    <svg version="1.1" id="logo" class="navbar-brand-img brand-sm"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 120 120" xml:space="preserve">
                        <g>
                            <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                            <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                            <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                        </g>
                    </svg>
                </a>
            <?php endif; ?>

            
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">

            <?php if(Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT'])): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('dashboard_management.index')); ?>" class="nav-link">
                        <i class="fe fe-airplay fe-16"></i>
                        <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
                    </a>
                </li>
            <?php elseif(Auth::check() && in_array(Auth::user()->role, ['OPERATOR'])): ?>
                <li class="nav-item w-100">
                    <a class="nav-link <?php echo $__env->yieldContent('menudashboard'); ?>" href="<?php echo e(route('dashboard_operator.index')); ?>">
                        <i class="fe fe-airplay fe-16"></i>
                        <span class="ml-3 item-text">Dashboard</span>
                    </a>
                </li>
            <?php elseif(Auth::check() && in_array(Auth::user()->role, ['ADMIN'])): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('dashboard_management.index')); ?>" class="nav-link">
                        <i class="fe fe-airplay fe-16"></i>
                        <span class="ml-3 item-text">Dashboard Management</span><span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item w-100">
                    <a class="nav-link <?php echo $__env->yieldContent('menudashboard'); ?>" href="<?php echo e(route('dashboard_operator.index')); ?>">
                        <i class="fe fe-airplay fe-16"></i>
                        <span class="ml-3 item-text">Dashboard Operator</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
        <p class="text-muted nav-heading mt-4 mb-1">
            <span>Main</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item dropdown">
                <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Activity List</span><span class="sr-only">(current)</span>
                </a>
                <?php if(Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT', 'ADMIN'])): ?>
                    <ul class="collapse list-unstyled pl-4 w-100" id="dashboard">
                        <li class="nav-item active">
                            <a class="nav-link pl-3" href="<?php echo e(route('task.index')); ?>"> <i class="fe fe-home fe-16"></i>
                                <span class="ml-1 item-text">Department Activity</span></a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link pl-3" href="<?php echo e(route('task_personal.index')); ?>"><i
                                    class="fe fe-home fe-16"></i> <span class="ml-1 item-text">Job Assignment</span></a>
                        </li>
                    </ul>
                <?php elseif(Auth::check() && in_array(Auth::user()->role, ['OPERATOR'])): ?>
                    <ul class="collapse list-unstyled pl-4 w-100" id="dashboard">
                        <li class="nav-item active">
                            <a class="nav-link pl-3" href="<?php echo e(route('task_personal.index')); ?>"><i
                                    class="fe fe-home fe-16"></i>
                                <span class="ml-1 item-text">Job Assignment</span></a>
                        </li>
                    </ul>
                <?php endif; ?>

            </li>
            <li class="nav-item w-100">
                <a class="nav-link" href="<?php echo e(route('activity_history.index')); ?>">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-3 item-text">Activity History</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#settings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-settings fe-16"></i>
                    <span class="ml-3 item-text">Settings</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="settings">
                    <?php if(Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT', 'ADMIN'])): ?>
                        <li class="nav-item w-100">
                            <a class="nav-link <?php echo $__env->yieldContent('menuactivity'); ?>" href="<?php echo e(route('activity.index')); ?>">
                                <i class="fe fe-activity fe-16"></i>
                                <span class="ml-3 item-text">Personal Activity</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item w-100">
                        <a class="nav-link <?php echo $__env->yieldContent('menucategory'); ?>" href="<?php echo e(route('category.index')); ?>">
                            <i class="fe fe-grid fe-16"></i>
                            <span class="ml-3 item-text">Activity Category</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo e(route('enduser_department.index')); ?>">
                            <i class="fe fe-users fe-16"></i>
                            <span class="ml-3 item-text">End User Department</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo e(route('enduser.index')); ?>">
                            <i class="fe fe-users fe-16"></i>
                            <span class="ml-3 item-text">End User Personal</span>
                        </a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link <?php echo $__env->yieldContent('menulocation'); ?>" href="<?php echo e(route('location.index')); ?>">
                            <i class="fe fe-map-pin fe-16"></i>
                            <span class="ml-3 item-text">Location</span>
                        </a>
                    </li>
                    <?php if(Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT', 'ADMIN'])): ?>
                        <li class="nav-item w-100">
                            <a class="nav-link" href="<?php echo e(route('user.index')); ?>">
                                <i class="fe fe-user fe-16"></i>
                                <span class="ml-3 item-text">User</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if(Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT', 'ADMIN'])): ?>
            <li class="nav-item dropdown">
                <a href="#export" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-download-cloud fe-16"></i>
                    <span class="ml-3 item-text">Export</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="export">
                    <li class="nav-item w-100">
                        <a class="nav-link <?php echo $__env->yieldContent('menulocation'); ?>" href="#" id="export-data">
                            <i class="fe fe-download fe-16"></i>
                            <span class="ml-3 item-text">Export Job Activity</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            </li>

        </ul>
    </nav>
</aside>
<?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>