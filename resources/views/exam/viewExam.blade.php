@extends('layouts.app', ['activePage' => 'exams', 'titlePage' => __('QUESTION Management')])

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
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6"><h3>Exam Name:{{$exam->title}}</h3></div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><label class="control-label">Duration:{{$exam->duration}}</label> </div>
                        <div class="col-sm-4"><label class="control-label">Question Count:{{$exam->question_count}}</label></div>
                        <div class="col-md-4"><label class="control-label">Cut Off:{{$exam->cutoff}}</label></div>
                        <div class="col-md-4"><label class="control-label">Correct Mark:{{$exam->correct_mark}}</label></div>
                        <div class="col-md-4"><label class="control-label">Negative Mark:{{$exam->negative_mark}}</label></div>
                    </div>
                    <div class="row">
                        
                       
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <!-- <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Notifications') }}</h4>
                <p class="card-category"> {{ __('Here you can manage notifications') }}</p>
              </div> -->
              <div class="card-body">
               
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ route('exam.addquestion', $exam->id) }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
              <div class="row">
                  <div class="col-md-12">
                  @foreach($examquestions as $question)
                                <div class="question-card">
                                    <p class="question">{{$question->question}}</p>
                                  
                                    <div class="row">
                                    @foreach ($question->getChoices($question->id) as $answer)
                                            <div class="col-md-6">
                                                @if ($answer->is_correct)
                                                   <p  class="correct">{{ $loop->iteration++ }}).{{$answer->choice}}</p>
                                                @else
                                                   <p class="answer" >{{ $loop->iteration++ }}).{{$answer->choice}}</p>
                                                @endif 
                                                
                                            </div>
                                    @endforeach
                                    </div>
                                    <a href="" class="btn btn-success">Edit Question</a>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="">
                                        <input type="submit" value="Delete" name="delete" class="btn btn-danger">
                                    </form>
                                </div>
                  @endforeach
                  
                  </div>
              </div>                    
              </div>
            </div>
        </div>
      </div>
     
    </div>
  </div>
@endsection