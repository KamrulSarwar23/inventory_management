  <!-- Navbar -->
<nav class="main-header navbar navbar-expand-lg navbar-light bg-white text-dark border-bottom py-2">
      <!-- Left navbar links -->
    <ul class="navbar-nav text-bold ">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

        <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('profile.index') }}" class="nav-link">Profile</a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
             <button type="submit" class="dropdown-item text-danger mt-1"><i
                 class="bi bi-box-arrow-right"></i>Logout</button>
             </form>
      </li>
    </ul>
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
 
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->