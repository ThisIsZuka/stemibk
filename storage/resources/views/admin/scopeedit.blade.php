@extends('layouts.app')
@section('title', 'User edit - Telecorp')
@section('content')

  <script src="{{asset('js/jquery-1.12.4.js')}}"></script>
  <script>

  $(function() {
    $("#datepicker").datepicker({format: 'dd-mm-yyyy'});
    $("#datepicker").on("change", function(){var fromdate = $(this).val();});
  });

  </script>




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


                        @if(isset($_GET['id']))
                          {{ Form::open(['method'=>'put','url'=>'admin_scopeupdate', 'enctype'=>'multipart/form-data'] )}}
                          <input type="hidden" name="scope_id" value="{{@$_GET['id']}}">
                        @else
                          {{ Form::open(['method'=>'put','url'=>'admin_scopeadd', 'enctype'=>'multipart/form-data'] )}}
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Scope</b></h4>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">


                                                <div class="form-row">

                                                  <div class="col-md-12">
                                                    <label for="inputEmail4" class="col-form-label">Scope Name </label>
                                                    <input name="scope_name" type="text" class="form-control" value="{{@$scope[0]->scope_name}}">
                                                  </div>
                                                </div>

                                                <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                    <label for="inputEmail4" class="col-form-label">Scope Brand </label>
                                                    <input name="scope_band" type="text" class="form-control" value="{{@$scope[0]->scope_band}}">
                                                  </div>
                                                </div>
                                                <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                    <label for="inputEmail4" class="col-form-label">Scope Model </label>
                                                    <input name="scope_model" type="text" class="form-control" value="{{@$scope[0]->scope_model}}">
                                                  </div>
                                                </div>

                                                <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                    <label for="inputEmail4" class="col-form-label">Serial Number </label>
                                                    <input name="scope_serial" type="text" class="form-control" value="{{@$scope[0]->scope_serial}}">
                                                  </div>
                                                </div>
                                                <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                    <label for="inputEmail4" class="col-form-label">Installation Date </label>

                                                    <input name="scope_installdate" type="text" class="form-control" id="datepicker" placeholder="วันที่นำเข้า" value="{{@$scope[0]->scope_installdate}}"   autocomplete="off">

                                                  </div>
                                                </div>



                                                <div class="form-row">
                                                  <div class="form-group col-md-3">
                                                    <label for="inputEmail4" class="col-form-label">Top </label>
                                                    <input name="scope_top" type="text" class="form-control" value="{{@$scope[0]->scope_top}}">
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                    <label for="inputEmail4" class="col-form-label">Bottom </label>
                                                    <input name="scope_bottom" type="text" class="form-control" value="{{@$scope[0]->scope_bottom}}">
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                    <label for="inputEmail4" class="col-form-label">Left </label>
                                                    <input name="scope_left" type="text" class="form-control" value="{{@$scope[0]->scope_left}}">
                                                  </div>
                                                  <div class="form-group col-md-3">
                                                    <label for="inputEmail4" class="col-form-label">Right </label>
                                                    <input name="scope_rigth" type="text" class="form-control" value="{{@$scope[0]->scope_rigth}}">
                                                  </div>

                                                </div>

                                                <div class="form-row">
                                                  <div class="form-group col-md-12">
                                                    <label for="inputEmail4" class="col-form-label">Comment </label>
                                                    <input name="scope_comment" type="text" class="form-control" value="{{@$scope[0]->scope_comment}}">
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
