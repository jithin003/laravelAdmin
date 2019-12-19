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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" align="center">
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
    </div>
  </div>
@endsection