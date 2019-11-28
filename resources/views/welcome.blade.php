@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('Exam App')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <h1 class="text-white text-center">{{ __('Welcome To Exam App.') }}</h1>
          <h2 class="text-white text-center">{{ __('The Complete Solution For Online Exam') }}</h2>
          <img src="{{ asset('material') }}/img/imac1.png" style="max-width: 100%;max-height: 100%;padding:30px;" alt="">
      </div>
  </div>
</div>
@endsection
