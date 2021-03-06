<!-- <div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg"> -->
<div class="sidebar" data-color="purple" data-background-color="white" >
<!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal">
    <img style="width:25px" src="{{ asset('material') }}/img/laravel.svg">
      <!-- {{ __('Exam App') }} -->
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="false">
          <!-- <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i> -->
          <i class="material-icons">face</i>
          <p>{{ __('User Management') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            @if(Auth::user()->role_id==1)
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
            @endif
          </ul>
        </div>
      </li>
      <!-- <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('table') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Table List') }}</p>
        </a>
      </li> -->
      <li class="nav-item{{ $activePage == 'course' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('course') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Course Management') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'subject' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('subject') }}">
          <i class="material-icons">book</i>
            <p>{{ __('Subject Management') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'user_import' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('importview') }}">
          <i class="material-icons">person</i>
            <p>{{ __('User Import') }}</p>
        </a>
      </li>
      <!-- <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('typography') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Typography') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('icons') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('map') }}">
          <i class="material-icons">location_ons</i>
            <p>{{ __('Maps') }}</p>
        </a>
      </li> -->
      <li class="nav-item{{ $activePage == 'notification' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('notifications') }}">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'attendance' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('attendance') }}">
          <i class="material-icons">add</i>
          <p>{{ __('Attendance') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'exam' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('exam') }}">
          <i class="material-icons">school</i>
          <p>{{ __('Exam') }}</p>
        </a>
      </li>
      <!-- <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('language') }}">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li> -->
      <!-- <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">unarchive</i>
          <p>{{ __('Upgrade to PRO') }}</p>
        </a> -->
      </li>
    </ul>
  </div>
</div>
