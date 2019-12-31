@extends('layouts.app', ['activePage' => 'subject', 'titlePage' => __('Subject Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('subject.store') }}"  class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add Subject') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('subject') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Subject Title') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="name" id="input-name" type="text" placeholder="{{ __('Subject Title') }}" value="" required="true" aria-required="true"/>
                      <!-- @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Subject Code') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="code" id="code" type="text" placeholder="{{ __('Course Code') }}" value=""  />
                      <!-- @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif -->
                    </div>
                  </div>
                </div>
                <!-- <div class="row">
                  <label class="col-sm-2 col-form-label" >{{ __(' Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input type="password" name="password" id="input-password" placeholder="{{ __('Password') }}" value="" required />
                      @if ($errors->has('password'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>
                </div> -->
                <!-- <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm Password') }}" value="" required />
                    </div>
                  </div>
                </div> -->
                
              </div>
              
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Add ') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
        
  </script>
  
  </div>
 
@endsection