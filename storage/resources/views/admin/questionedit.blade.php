@extends('layouts.app')
@section('title', 'User edit - Telecorp')
@section('content')

      <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Question</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
                        <!-- end row -->

                        {{--Form::open(['method'=>'put','route'=>['useredit',1]])--}}
                        {{--Form::open(['url'=>'useredit'])--}}
                        @if(isset($_GET['procedure_id']))
                          {{ Form::open(['method'=>'put','route'=>['admin_question.update',$_GET['procedure_id']],'enctype'=>'multipart/form-data'])}}
                          {{-- Form::open(['method'=>'put','url'=>'admin_procedureupdate', 'enctype'=>'multipart/form-data'] )--}}
                        @else
                          {{ Form::open(['url'=>'admin_question', 'enctype'=>'multipart/form-data'] )}}
                        @endif
                        <input type="hidden" name="procedure_id" value="{{@$_GET['procedure_id']}}">
                        {{-- {{Form::open(['method'=>'put','route'=>['patient.update',$patient->id]])}} --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                      <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4" class="col-form-label">Question Title </label>
                                                        <input name="question_title" type="text" class="form-control" value="{{@$question[0]->question_title}}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-box -->
                            </div><!-- end col -->
                        </div>


    {{--#####          #####--}}
        </div>
      </div>
    </div>
    <!-- end row -->





                    </div> <!-- container -->
{{ Form::close()}}

                <footer class="footer text-right">
                    © Telecorp.
                </footer>

@endsection
