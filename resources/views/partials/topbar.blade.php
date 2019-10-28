
<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/admin/home') }}" class="logo"
       style="font-size: 16px;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
           @lang('global.global_title_Mini')</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
           @lang('global.global_title')</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            {{--<span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>--}}
            <i class="fa fa-fw fa-bars"></i>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
            @else

                <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a class="dropdown-toggle">
                            <!-- The user image in the navbar-->
                            <img src="{{asset('/img/avatar_plusis.png')}}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>

                        </a>

                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{asset('/img/avatar_plusis.png')}}" class="img-circle" alt="User Image"/>
                                <p>
                                    <a style="color:#fff!important;">{{ Auth::user()->name }}</a>
                                </p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">

                                    <a href="{{ route('auth.change_password') }}"
                                       class="btn btn-default btn-flat btn-sm hidden">
                                        Cambiar Contraseña
                                    </a>

                                </div>
                                <div class="col-lg-12">

                                    <a href="{{ url('/logout') }}" id="cerrar"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" id='cerrars'
                                       class="btn btn-default btn-xs btn-flat col-lg-12">
                                        Cerrar Sesi&oacute;n
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>


                                </div>
                            </li>
                        </ul>
                    </li>
            @endif

            <!-- Control Sidebar Toggle Button -->

            </ul>
        </div>
    </nav>
</header>


