  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-dark navbar-gray">
    <!-- Left navbar links -->
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" ><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- SEARCH FORM -->


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->

      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/client/profile')}}" class="nav-link">
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-bars"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Client Settings</span>
            <div class="dropdown-divider"></div>
            <a href="{{url('/client/profile')}}" class="dropdown-item">
              <i class="fas fa-user"></i> Client Profile
            </a>

            <div class="dropdown-divider"></div>
            <a href="#"  class="dropdown-item" href="{{ url('client/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                <span class="float-right text-muted text-sm">{{ __('Last Logged In') }}- time</span>
            </a>
            <form id="logout-form" action="{{ url('client/logout') }}" method="POST" class="d-">
                @csrf
            </form>

          </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
