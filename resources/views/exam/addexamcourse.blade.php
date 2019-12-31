@extends('layouts.app', ['activePage' => 'exams', 'titlePage' => __('QUESTION Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row" >
        <div class="col-md-6">
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
                @if ($errors->any())
                  <div class="alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                    </ul>
                    </div>
                @endif
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('exam.create') }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
                <div class="row" >
                <div class="col-md-12">
                            <form method="post" action="{{ route('exam.addcourse') }}"  class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label class="control-label ">Exams</label>
                                        <!-- <input type="text" class="form-control question-page" name="correct_answer"  /> -->
                                        <select class="form-control " name="examid"  id="examid" >
                                          <option value="">--Select Exam--</option>
                                          @foreach($exams as $exam)
                                          <option value="{{$exam->id}}">{{$exam->title}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label class="control-label ">Course</label>
                                        <select name="course[]" style="height:100px;" class="form-control" multiple id="course" required>
                                          <option value="">--Select Course--</option>
                                          @foreach($courses as $course)
                                          <option value="{{$course->id}}">{{$course->course_title}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <div class="form-group" style="padding-top:15px;">
                                            <label class="control-label" style="color:black;">Exam Date</label>
                                            <input type="date" class="form-control" placeholder="Exam Start Date" name="start_date"  required />
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Add To Course ') }}</button>
                            </form>
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