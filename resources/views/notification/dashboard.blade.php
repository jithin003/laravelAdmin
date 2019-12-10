@extends('layouts.app', ['activePage' => 'notification', 'titlePage' => __('Notification Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <!-- <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Notifications') }}</h4>
                <p class="card-category"> {{ __('Here you can manage notifications') }}</p>
              </div> -->
              <div class="card-body">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('notification.create') }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header card-header-info">
                              
                            </div>
                            <div class="card-body" align="center">
                                <!-- <h3><a href="">List Notification</a></h3> -->
                                <i class="material-icons">list</i>
                                <h4 class="">{{ __('Notification List') }}</h4>
                                <p class=""> {{ __('List All Notifications') }}</p>
                                <a href="{{ route('notification.list', 'all') }}" class="btn btn-sm btn-primary">{{ __('LIST') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header card-header-info">
                               
                            </div>
                            <div class="card-body" align="center"> 
                            <i class="material-icons">list</i>
                                <h4 class="card-title ">{{ __('Institute Wide ') }}</h4>
                                <p class="card-category"> {{ __('List institude wide notification') }}</p>
                                <a href="{{ route('notification.list', 'institute') }}" class="btn btn-sm btn-primary">{{ __('INSTITUTE WIDE LIST') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header card-header-info">
                                
                            </div>
                            <div class="card-body" align="center">
                                <i class="material-icons">group</i>
                                <h4 class="card-title ">{{ __('Staff Notifications') }}</h4>
                                <p class="card-category"> {{ __('Here you can manage staff notifications') }}</p>
                                <a href="{{ route('notification.list', 'staff') }}" class="btn btn-sm btn-primary">{{ __('STAFF WIDE LIST') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header card-header-info">
                                
                            </div>
                            <div class="card-body " align="center">
                                <i class="material-icons">class</i>
                                <h4 class="card-title ">{{ __('Class Notifications') }}</h4>
                                <p class="card-category"> {{ __('Here you can manage class/batch notifications') }}</p>
                                <a href="{{ route('notification.list', 'class') }}" class="btn btn-sm btn-primary">{{ __('CLASS WIDE LIST') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header card-header-info">
                                
                            </div>
                            <a href="{{ route('notification.create') }}">
                            <div class="card-body " align="center">
                                <i class="material-icons">add</i>
                                <h4 class="card-title ">{{ __('Add New Notification') }}</h4>
                                <p class="card-category"> {{ __('Here you can create notifications') }}</p>
                                <a href="{{ route('notification.create') }}" class="btn btn-sm btn-primary">{{ __('NEW') }}</a>
                            </div>
                            </a>
                            
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection