@extends('layouts.app', ['activePage' => 'notification', 'titlePage' => __('Notification Management')])

@section('content')

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('notification.store') }}"  class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add Notification') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('notifications') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Title*') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="title" id="title" type="text" placeholder="{{ __('Title') }}" value="" required="true" aria-required="true"/>
                      <!-- @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Message') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <!-- <input class="form-control" name="message" id="message" type="text" placeholder="{{ __('Message') }}" value="" required /> -->
                      <textarea class="form-control" name="message" id="message" rows = "5" cols = "40"  placeholder="{{ __('Message') }}" required >
                                </textarea>
                      <!-- @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif -->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="type" style="padding-top:20px;">{{ __(' Role') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    <select class="form-control" name="type"  id="type">
                      <option value="">--Select--</option>
                      <option value="all">ALL</option>
                      <option value="student">Student</option>
                      <option value="staff">Staff</option>
                    </select>
                    </div>
                  </div>
                </div>
                <div name="inputArea" id="inputArea">
                    
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="image" style="padding-top:20px;">{{ __(' Image') }}</label>
                  <div class="col-sm-7">
                    
                    <input type="file" name="image" id="image" class="form-control">
                    
                  </div>
                </div>
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
  <script>
          $(document).ready(function(){
              $('[data-toggle="tooltip"]').tooltip();   
            });
         $("#type").change(function () {
                var status = $(this).val();
                if (status=='student')
                {
                 
                  $("#courseArea").remove();
                   $('#inputArea').empty();
                    $("#inputArea").append("<div class='row' name='courseArea' id='courseArea'><label for='course' class='col-sm-2 col-form-label'>Course </label><div class='col-sm-7'><div class='form-group'><select id='course' style='height:100px;' name='course[]' class='form-control' multiple></select> </div></div><div class='col-sm-1'><a href='#' data-toggle='tooltip' data-placement='left' data-html='true' title='<b>Select Courses for sending<br> notification to multiple courses!</b>'><i class='material-icons'>priority_high</i></a></div></div>");
                    $.get('/usercourse', function(data) {
                            console.log(data);
                            $('#course').empty();
                            //$('#course').append('<option value="0" disable="true" selected="true">--- Select Course ---</option>');

                            $.each(data, function(index, regenciesObj) {
                            $('#course').append('<option value="' + regenciesObj.id + '">' + regenciesObj.course_title + '</option>');
                            })
                        });
                }
                else
                {
                 
                 
                    $("#courseArea").remove();
                     $('#inputArea').empty();
                }
            
            });
  </script>
@endsection