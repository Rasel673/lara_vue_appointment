<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ setting('app_name') }}</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->avatar }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin</a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <router-link to='/admin/dasboard' active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </router-link>
                </li>


                <li class="nav-item">
                    <router-link to='/admin/appoinment'
                        :class="$route.path.startsWith('/admin/appoinment') ? 'active' : ''" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Appoinments
                        </p>
                    </router-link>
                </li>


                <li class="nav-item">
                    <router-link to='/admin/users' active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </router-link>
                </li>




                <li class="nav-item">
                    <router-link to='/admin/update_profile' active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Update Profile
                        </p>
                    </router-link>
                </li>



                <li class="nav-item">
                    <router-link to='/admin/todo' active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-task"></i>
                        <p>
                            Todo
                        </p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to='/admin/update_settings' active-class="active" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                        </p>
                    </router-link>
                </li>


                <li class="nav-item">

                    <form action="{{ route('logout') }}" method="POST" class="nav-link">
                        @csrf
                        <a href='#' onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </form>


                </li>

            </ul>
        </nav>

    </div>

</aside>
