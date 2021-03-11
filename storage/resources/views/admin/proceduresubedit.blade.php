@extends('layouts.app')
@section('title', 'User edit - Telecorp')
@section('content')

      <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Staining Sub</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
                        <!-- end row -->


                        {{--Form::open(['method'=>'put','route'=>['useredit',1]])--}}
                        {{--Form::open(['url'=>'useredit'])--}}
                        @if(isset($_GET['psub_id']))
                          {{ Form::open(['method'=>'put','url'=>'admin_proceduresubupdate', 'enctype'=>'multipart/form-data'] )}}
                          <input type="hidden" name="psub_id" value="{{@$_GET['psub_id']}}">
                        @else
                          {{ Form::open(['method'=>'put','url'=>'admin_proceduresubadd', 'enctype'=>'multipart/form-data'] )}}
                          <input type="hidden" name="procedure_id" value="{{@$_GET['procedure_id']}}">
                        @endif

                        {{-- {{Form::open(['method'=>'put','route'=>['patient.update',$patient->id]])}} --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">


                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4" class="col-form-label">Staining Sub </label>
                                                        <input name="psub_name" type="text" class="form-control" value="{{@$procedure_sub[0]->stainingsub_name}}">
                                                        <input name="procedure_id" type="hidden" value="{{$_GET['procedure_id']}}" >
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
                    </div> <!-- container -->
{{ Form::close()}}

                <footer class="footer text-right">
                    © Telecorp.
                </footer>

@endsection
