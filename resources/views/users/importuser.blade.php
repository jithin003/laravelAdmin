@extends('layouts.app', ['activePage' => 'user_import', 'titlePage' => __('User Import')])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Users') }}</h4>
                <p class="card-category"> {{ __('Here you can manage users') }}</p>
              </div>
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
                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('Add user') }}</a>
                  </div>
                </div>
                <div >
                        <form action="{{ route('import') }}" style="margin-top:50px;" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 text-center">
                                     <button class="btn btn-sm btn-success">Import</button>
                                </div>
                                <div class="col-6 text-center">
                                <a class="btn btn-sm btn-warning" href="{{ route('export') }}">Export</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
              
@endsection