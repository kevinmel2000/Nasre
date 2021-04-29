  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-dark navbar-gray">
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" ><i class="fas fa-bars  pt-1"></i></a>
      </li>
      <li class="nav-item">
        <a type="button" class="nav-link" href="{{url()->previous()}}">
          <i class="fas fa-arrow-circle-left mr-1"></i>
          {{__('Previous Page')}}
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item nav-link d-none d-sm-inline-block">
          User ID - {{Auth::user()->id}}
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/user/profile')}}" class="nav-link">
          {{Auth::user()->name}}
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-users-cog pt-1" href="#"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header" >{{__('User Settings')}}</span>
            <div class="dropdown-divider"></div>
            <a href="{{url('/user/profile')}}" class="dropdown-item">
              <i class="fas fa-user"></i> {{__('User Profile')}}
            </a>

            <div class="dropdown-divider"></div>
            <a href="#"  class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" class="d-hide" method="POST">
                @csrf
            </form>
          </div>
      </li>
    </ul>
  </nav>
