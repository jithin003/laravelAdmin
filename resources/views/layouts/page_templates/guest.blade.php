@include('layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page">
  <!-- <div class="page-header login-page header-filter" filter-color="black" style="background: rgb(2,0,36);
background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%); background-size: cover; background-position: top center;align-items: center;" data-color="purple"> -->
<div class="page-header login-page header-filter landing-bg" >
 <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    @yield('content')
    @include('layouts.footers.guest')
  </div>
</div>
