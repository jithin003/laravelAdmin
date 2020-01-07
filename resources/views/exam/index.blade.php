@extends('layouts.app', ['activePage' => 'exams', 'titlePage' => __('Exam Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card">
          
            <div class="card-header card-header-tabs card-header-danger">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title">Exams:</span>
                  <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#profile" data-toggle="tab">
                        <i class="material-icons">bug_report</i> All
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#messages" data-toggle="tab">
                        <i class="material-icons">code</i> Allocated To Courses
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                   
                  </ul>
                </div>
              </div>
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
              <div class="tab-content">
                <div class="tab-pane active" id="profile">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('exam.create') }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Duration') }}
                      </th>
                      <th>
                        {{ __('No of Questions') }}
                      </th>
                      <th>
                        {{ __('Cutoff') }}
                      </th>
                      <th class="text-right">
                        {{ __('Actions') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($allexams as $exam)
                        <tr>
                          <td>
                            {{$exam->title}}
                          </td>
                          <td>
                            {{$exam->duration}}
                          </td>
                          <td>
                            {{ $exam->question_count }}
                          </td>
                          <td>
                            {{ $exam->cutoff }}
                          </td>
                          <td class="td-actions text-right">
                           
                              <form action="{{ route('exam.destroy', $exam) }}" method="post">
                                  @csrf
                                  @method('delete')
                                  <div class="row">
                                    <div class="col-sm-1">
                                      <a rel="tooltip" class="btn btn-warning " href="{{ route('exam.view', $exam) }}" data-original-title="" title="">
                                        View 
                                        <div class="ripple-container"></div>
                                      </a>
                                    </div>
                                    <div class="col-sm-1">
                                      <a rel="tooltip" class="btn btn-success " href="{{ route('exam.edit', $exam) }}" data-original-title="" title="">
                                          Edit  
                                          <div class="ripple-container"></div>
                                      </a>
                                    </div>
                                    <div class="col-sm-1">
                                      <button type="button" class="btn btn-danger " data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this exam?") }}') ? this.parentElement.submit() : ''">
                                              Delete   
                                            <div class="ripple-container"></div>
                                      </button>
                                    </div>
                                    <div class="col-sm-3">
                                      <a rel="tooltip" class="btn btn-info " href="{{ route('exam.addquestion', $exam) }}" data-original-title="" title="">
                                          Add Question
                                            <div class="ripple-container"></div>
                                      </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a rel="tooltip" class="btn btn-primary " href="{{ route('exam.addcourse') }}" data-original-title="" title="">
                                          Add To Course
                                          <div class="ripple-container"></div>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <a rel="tooltip" class="btn btn-info " href="{{ route('exam.report', $exam) }}" data-original-title="" title="">
                                          Exam Report 
                                          <div class="ripple-container"></div>
                                        </a>
                                    </div>
                                  </div>
                                  <!-- //******* */ -->
                                  <div class="row">
                                   
                                  </div>
                                 

                              </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                </div>
                <div class="tab-pane" id="messages">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('exam.create') }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Course') }}
                      </th>
                      <th>
                        {{ __('Date of Exam') }}
                      </th>
                      <th class="text-right">
                        {{ __('Actions') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($exams as $exam)
                        <tr>
                          <td>
                            {{$exam->title}}
                          </td>
                          <td>
                            {{$exam->course_title}}
                          </td>
                          <td>
                            {{ $exam->live_on }}
                          </td>
                          <td class="td-actions text-right">
                           
                              <form action="{{ route('exam.destroy', $exam) }}" method="post">
                                  @csrf
                                  @method('delete')
                              
                                  <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('exam.edit', $exam) }}" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                  </a>
                                  <button type="button" class="btn btn-danger btn-link" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this exam?") }}') ? this.parentElement.submit() : ''">
                                      <i class="material-icons">close</i>
                                      <div class="ripple-container"></div>
                                  </button>
                              </form>
                          </td>
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
@endsection