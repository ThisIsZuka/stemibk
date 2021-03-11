@extends('layouts.app')
@section('title', 'User edit - Telecorp')
@section('content')

      <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">User</h4>

                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="#">Administrator</a></li>
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                    </ol>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
                        <!-- end row -->


                        @if(isset($_GET['mainpartsub_id']))

                          {{ Form::open(['method'=>'put','url'=>'admin_mainpartsubupdate', 'enctype'=>'multipart/form-data'] )}}
                          <input type="hidden" name="mainpartsub_id" value="{{@$_GET['mainpartsub_id']}}">
                        @else

                          {{ Form::open(['method'=>'put','url'=>'admin_mainpartsubadd', 'enctype'=>'multipart/form-data'] )}}
                          <input type="hidden" name="mainpart_id" value="{{@$_GET['mainpart_id']}}">

                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Main part sub</b></h4>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">


                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4" class="col-form-label">Procedure Sub </label>
                                                        <input name="mainpartsub_name" type="text" class="form-control" value="{{@$mainpartsub[0]->mainpartsub_name}}">
                                                        <input name="mainpart_id" type="hidden" value="{{$_GET['mainpart_id']}}">
                                                        <input name="procedure_id" type="hidden" value="{{$_GET['procedure_id']}}">

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
