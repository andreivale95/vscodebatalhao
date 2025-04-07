<header class="main-header">


    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><img src="{{ env('APP_URL') . '/assets/img/logo.png' }}" alt=""
                    height="45"></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"> <img src="{{ env('APP_URL') . '/assets/img/logo.png' }}" alt="" height="45">
            <b>SISALMOX</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>


        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!--  <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bell-o"></i>
                      <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">Você tem novos Processos Atríbuidos</li>
                      <li>

                        <ul class="menu">

                          <li>
                            <a href="#">
                              <i class="fa fa-folder text-red"></i> 15 Novos Processos
                            </a>
                          </li>


                        </ul>
                      </li>
                      <li class="footer"><a href="#">Ver Todos os Processos</a></li>
                    </ul>
                  </li> -->

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ env('APP_URL') . '/privace/images/' . Auth::user()->image }}" class="user-image"
                            class="avatar img-circle img-thumbnail" alt="avatar">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->nome }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            @if (Auth::user()->image)
                                <div class="text-center">
                                    <img class="image rounded-circle"
                                        src="{{ env('APP_URL') . '/privace/images/' . Auth::user()->image }}"
                                        alt="profile_image" class="avatar img-circle img-thumbnail" alt="avatar"
                                        style="width: 80px;height: 80px; padding: 10px; margin: 0px; "><br>
                                </div>
                            @endif
                            <small><a href="{{ route('foto.perfil') }}"> Alterar Foto do Perfil </a> </small>

                            <p>
                                {{ Auth::user()->nome }}
                                <small>{{ Auth::user()->perfil()->get()->first()->nome }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('profile.ver', Auth::user()->cpf) }}"
                                    class="btn btn-default btn-flat"> Minha Conta</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
