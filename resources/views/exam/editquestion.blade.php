@extends('layouts.app', ['activePage' => 'exams', 'titlePage' => __('QUESTION Management')])

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
                    <a href="{{ route('question.create') }}" class="btn btn-sm btn-primary">{{ __('Add') }}</a>
                  </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                            <form method="post" action="{{ route('question.store') }}"  class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('post')
 
                                <div class="form-group">
                                    <label class="control-label">Question</label>
                                    <input type="text" class="form-control " placeholder="Enter Question" name="question" value="{{ old('question') }}"  required />
                                </div>
                                <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label class="control-label" for="answers">Option 1</label>
                                      <input type="text " class="form-control question-page" name="correct_answer1" value="{{ old('correct_answer1') }}"  required />
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label class="control-label" for="answers">Option 2</label>
                                      <input type="text" class="form-control question-page" name="correct_answer2" value="{{ old('correct_answer2') }}"  required />
                                    </div>

                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="answers">Option 3</label>
                                        <input type="text" class="form-control question-page" name="correct_answer3" value="{{ old('correct_answer3') }}"  />
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="answers">Option 4</label>
                                        <input type="text" class="form-control question-page" name="correct_answer4" value="{{ old('correct_answer4') }}"  />
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="answers">Option 5</label>
                                        <input type="text" class="form-control question-page" name="correct_answer5" value="{{ old('correct_answer5') }}" />
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="control-label ">Correct Answer</label>
                                      <!-- <input type="text" class="form-control question-page" name="correct_answer"  /> -->
                                      <select class="form-control " name="correct_answer"  id="correct_answer" >
                                        <option value="">--Select Option--</option>
                                        <option value="correct_answer1">OPTION 1</option>
                                        <option value="correct_answer2">OPTION 2</option>
                                        <option value="correct_answer3">OPTION 3</option>
                                        <option value="correct_answer4">OPTION 4</option>
                                        <option value="correct_answer5">OPTION 5</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="control-label ">Category/Subject</label>
                                      <select class="form-control" name="subject"  id="subject" >
                                        <option value="">--Select Subject--</option>
                                        @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}">{{$subject->title}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="Description">Description to the Answer</label>
                                    <textarea name="description" class="form-control question-page" rows="5" >{{ old('description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <div id="preview_photo" class="preview-box">
                                        <label for="photo" id="label_photo" class="file-input-label">
                                            <i class="fa fa-image"></i> Select Image
                                        </label>
                                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Add ') }}</button>
                            </form>
                        </div>
                       
              </div>                     
              </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                        <div class="col-md-12">
                            <div class="card">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Exam Name</th>
                                            <th>Date</th>
                                            <th>Course</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
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