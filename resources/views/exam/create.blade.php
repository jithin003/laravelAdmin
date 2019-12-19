@extends('layouts.app', ['activePage' => 'exams', 'titlePage' => __('Exam Management')])

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
                    <a href="{{ route('exam.create') }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                            <form method="post" action="{{ route('exam.store') }}"  class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('post')    
                            <div class="form-group" style="padding-top:15px;">
                                    <label class="control-label " style="color:black;" >Exam Name</label>
                                    <input type="text" class="form-control" placeholder="Exam Name" name="name"  required />
                                </div>
                                <div class="form-group" style="padding-top:15px;">
                                    <label for="courSe_id " class="control-label " style="color:black;" >Course</label>
                                        <select name="course[]" style="height:100px;" class="form-control" multiple id="course" required>
                                        <option selected hidden disabled>Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{$course->id}}">{{$course->course_title}}</option>
                                          @endforeach
                                        </select>
                                </div>
                                <div class="form-group" style="padding-top:15px;">
                                    <label class="control-label" style="color:black;">No.Of Questions For Exam</label>
                                    <input type="number" name="count" placeholder="No.Of Questions For Exam" class="form-control" min="1"  required>
                                </div>
                                <div class="form-group" style="padding-top:15px;">
                                    <label class="control-label" style="color:black;">Mark for a correct Answer</label>
                                    <input type="number" class="form-control" step=0.01 name="correct_mark" min="1"  required />
                                </div>
                                <div class="form-group" style="padding-top:15px;">
                                    <label class="control-label" style="color:black;">-ve Mark for an incorrect Answer</label>
                                    <input type="number" class="form-control" step=0.01 name="incorrect_mark" min="0"  required />
                                </div>
                                <div class="form-group" style="padding-top:15px;">
                                    <label class="control-label" style="color:black;">Exam Date</label>
                                    <input type="date" class="form-control" placeholder="Exam Start Date" name="start_date"  required />
                                </div>
                                <div class="form-group" style="padding-top:15px;">
                                    <label class="control-label" style="color:black;">Cutt Off</label>
                                    <input type="number" class="form-control" step=0.01 placeholder="Exam Cutt Off" name="cuttoff"  required />
                                </div>
                                <div class="form-group" style="padding-top:15px;">
                                    <label class="control-label" style="color:black;">Duration of the Exam</label>
                                    <input type="number" name="duration" placeholder="Duration in Minutes" class="form-control" min="1"  required>
                                </div>
                                <input type="hidden" name="status" value="1" />
                                <button type="submit" class="btn btn-primary">{{ __('Add ') }}</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Exam Name</th>
                                            <th>Date</th>
                                            <th>Course</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($exams as $exam)
                                        <tr>
                                            <th>{{$exam->title}}</th>
                                            <th>{{$exam->live_on}}</th>
                                            <th>{{$exam->course_title}}</th>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                         
                        </div>
              </div>                     
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection