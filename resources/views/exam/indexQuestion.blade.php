@extends('layouts.app', ['activePage' => 'exams', 'titlePage' => __('Exam Management')])

@section('content')
<style>
a+a {
  margin-left: 10px;
}
</style>
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
                    <a href="{{ route('question.create') }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body" align="center">
                            <form action="/search" method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q"
                                        placeholder="Search users"> <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Question</th>
                                            <th>Description</th>
                                            <th>Category/Subject</th>
                                            <th>Answer Options</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration++ }}</td>
                                            <td>{{$question->question}}</td>
                                            <td>{{$question->description}}</td>
                                            <td>{{$question->title}}</td>
                                            <td>
                                     
                                            @foreach ($question->getChoices($question->id) as $answer)
                                               
                                                @if ($answer->is_correct)
                                                   <a href=""  style="color:green">{{ $loop->iteration++ }}).{{$answer->choice}}</a>
                                                @else
                                                   <a href=""  >{{ $loop->iteration++ }}).{{$answer->choice}}</a>
                                                @endif 
                                               
                                            @endforeach
                                          
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
  </div>
@endsection