@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('user.store') }}"  class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add User') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required="true" aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required />
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Mobile') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('mobile') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="mobile" type="text" placeholder="{{ __('Mobile Number') }}" value="{{ old('mobile') }}" required />
                      @if ($errors->has('mobile'))
                        <span id="mobile-error" class="error text-danger" for="mobile">{{ $errors->first('mobile') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __(' Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input type="password" name="password" id="input-password" placeholder="{{ __('Password') }}" value="" required />
                      @if ($errors->has('password'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm Password') }}" value="" required />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="role_id" style="padding-top:20px;">{{ __(' Role') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    <select class="form-control" name="role_id"  id="role_id">
                      <option value="">--Select--</option>
                      @foreach($roles as $role)
                      <option value="{{$role->id}}">{{$role->name}}</option>
                      @endForeach
         
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
                
              </div>
              
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Add User') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
         $("#role_id").change(function () {
                var role_id = $(this).val();
                if (role_id==3)
                {
                 
                  $("#admissionArea").remove();
                  $("#courseArea").remove();
                   $('#inputArea').empty();
                    $("#inputArea").append("<div class='row' name='admissionArea' id='admissionArea'><label for='admission' class='col-sm-2 col-form-label'>Admission Number </label> <div class='col-sm-7'><div class='form-group'> <input class='form-control' id='admission' name='admission' placeholder='Admission Number' value='' /></div></div></div>");
                    $("#inputArea").append("<div class='row' name='courseArea' id='courseArea'><label for='course' class='col-sm-2 col-form-label'>Course </label><div class='col-sm-7'><div class='form-group'><select id='course' name='course' class='form-control'></select></div></div></div>");
                    $.get('/usercourse', function(data) {
                            console.log(data);
                            $('#course').empty();
                            $('#course').append('<option value="0" disable="true" selected="true">--- Select Course ---</option>');

                            $.each(data, function(index, regenciesObj) {
                            $('#course').append('<option value="' + regenciesObj.id + '">' + regenciesObj.course_title + '</option>');
                            })
                        });
                }
                else if (role_id==2)
                {
                 
                  $("#admissionArea").remove();
                  $("#courseArea").remove(); 
                  $('#inputArea').empty();
                    $("#inputArea").append("<div class='row' name='admissionArea' id='admissionArea'><label for='qualification' class='col-sm-2 col-form-label'>Qualification </label> <div class='col-sm-7'><div class='form-group'> <input class='form-control'  id='qualification' name='qualification'  placeholder='Eg:MBA,MCA' value='' /></div></div></div>");
                    $("#inputArea").append("<div class='row' name='admissionArea' id='admissionArea'><label for='job' class='col-sm-2 col-form-label'>Job Title </label> <div class='col-sm-7'><div class='form-group'> <input class='form-control'  id='job' name='job'  placeholder='Proffesor' value='' /></div></div></div>");
                    $("#inputArea").append("<div class='row' name='admissionArea' id='admissionArea'><label for='dateofjoin' class='col-sm-2 col-form-label'>Date Of Join </label> <div class='col-sm-7'><div class='form-group'> <input typt='date' class='form-control'  id='dateofjoin' name='dateofjoin'  placeholder='dd/mm/yyyy' value='' /></div></div></div>");

                }
                else
                {
                 
                  $("#admissionArea").remove();
                    $("#courseArea").remove();
                     $('#inputArea').empty();
                }
            
            });
  </script>
  <!-- <script>
         $("#role").change(function () {
                var role_id = $(this).val();
                if (role_id==5)
                {
                    $("#admissionArea").remove();
                    $("#rollnoArea").remove();
                    $("#inputArea").append("<div class='form-group' name='admissionArea' id='admissionArea'><label for='admission' class='col-sm-3 control-label'>Admission Number </label><div class='col-sm-9'><input type='text' id='admission' placeholder='Admission Number' class='form-control form-group' name= 'admission' required></div></div><div class='form-group' name='rollnoArea' id='rollnoArea'><label for='rollno' class='col-sm-3 control-label'>Roll Number </label><div class='col-sm-9'><input type='text' id='rollno' placeholder='Roll Number' class='form-control form-group' name= 'rollno' ></div></div> ");
                    $("#courseArea").append("<div class='form-group'><label for='course' class='col-sm-3 control-label '>Course </label><div class='col-sm-9'><select id='course' name='course' class='form-control form-group course'></select></div></div>");
                    
                }
                else if (role_id==3)
                {
                    $("#admissionArea").remove();
                    $("#rollnoArea").remove();
                    $("#inputArea").append("<div class='form-group' name='admissionArea' id='admissionArea'><label for='job' class='col-sm-3 control-label'>Job Title </label><div class='col-sm-9'><select id='job' name='job' class='form-control form-group'><option value='class_teacher'>Class Teacher</option>  <option value='teacher'>Teacher</option><option value='non teaching'>Non Teaching</option></select></div></div>");
                    $("#courseArea").append("<div class='form-group'><label for='course' class='col-sm-3 control-label '>Course </label><div class='col-sm-9'><select id='course' name='course' class='form-control form-group course'></select></div></div>");
                }
                else
                {
                $("#admissionArea").remove();
                $("#rollnoArea").remove();
                }
            
            });
        $('#school').on('change', function(e) {
                        console.log(e);
                        var school_id = e.target.value;
                        getCourse(school_id);
                                        
                        });
                    window.onload = function() {
                    var school_id = document.getElementById('school').value;
                    getCourse(school_id);
                    };

                    function getCourse(school_id) {
                        $.get('/course, function(data) {
                            console.log(data);
                            $('#course').empty();
                            $('#course').append('<option value="0" disable="true" selected="true">--- Select Course ---</option>');

                            $.each(data, function(index, regenciesObj) {
                            $('#course').append('<option value="' + regenciesObj.id + '">' + regenciesObj.course_title + '</option>');
                            })
                        });
                    }

                    
        </script> -->
  </div>
 
@endsection