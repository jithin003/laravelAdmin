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
                        <div class="col-sm-6"><h3>Exam Name:{{$exam[0]->title}}</h3></div>
                        <input  name="exam" id="exam" type="text"  value="{{ $exam[0]->exam_id }}" required="true" hidden/>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><label class="control-label">Duration:{{$exam[0]->duration}}</label> </div>
                        <div class="col-sm-4"><label class="control-label">Question Count:{{$exam[0]->question_count}}</label></div>
                        <div class="col-md-4"><label class="control-label">Cut Off:{{$exam[0]->cutoff}}</label></div>
                        <div class="col-md-4"><label class="control-label">Correct Mark:{{$exam[0]->correct_mark}}</label></div>
                        <div class="col-md-4"><label class="control-label">Negative Mark:{{$exam[0]->negative_mark}}</label></div>
                    </div>
                    <div class="row">
                              <div class="col-sm-12">
                               <label for="course_id " style="color:black;" >Course</label>
                                            <select name="course"  class="form-control"  id="course" required>
                                            <option value="" >---Select Course---</option>
                                            @foreach($exam as $course)
                                                <option value="{{$course->course_id}}">{{$course->course_title}}</option>
                                            @endforeach
                                            </select>
                              </div>  
                                       
                              
                       
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
                    <a href="{{ route('exam.create') }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
              <div class="row">
                  <div class="col-md-12">
                  <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        {{ __('Id') }}
                      </th>
                      <th>
                          {{ __('Name') }}
                      </th>
                      <th>
                        {{ __('Score') }}
                      </th>
                      <th>
                        {{ __('Status') }}
                      </th>

                    </thead>
                    <tbody name="inputArea" id="inputArea">
                        
                    </tbody>
                    </table>
                  </div>
              </div>                    
              </div>
            </div>
        </div>
      </div>
     
    </div>
    <script>
         $("#course").change(function () {
                var course = $(this).val();
                var examId = $('#exam').val();
                 
                
                   $('#inputArea').empty();
                   
                    $.get('course/'+course+'/report/', function(data) {
                            console.log(data);
                           
                           

                            $.each(data, function(index, regenciesObj) {
                            $('#inputArea').append('<tr><td>' + regenciesObj.user_id + '</td><td>'+regenciesObj.name+'</td><td>'+regenciesObj.score+'</td><td>'+regenciesObj.is_pass+'</td></tr>');
                            })
                        });
              
               
            
            });
  </script>
  </div>
@endsection