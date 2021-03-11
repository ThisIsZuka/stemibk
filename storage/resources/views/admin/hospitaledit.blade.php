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


                        @if(isset($_GET['hospital_id']))
                          {{ Form::open(['method'=>'put','url'=>'admin_hospitalupdate', 'enctype'=>'multipart/form-data'] )}}
                          <input type="hidden" name="hospital_id" value="{{@$_GET['hospital_id']}}">
                        @else
                          {{-- Form::open(['method'=>'put','url'=>'admin_roomadd', 'enctype'=>'multipart/form-data'] ) --}}
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Hostpital</b></h4>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">


                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                      <label for="inputEmail4" class="col-form-label">Hospital Name </label>
                                                        <input name="hospital_name" type="text" class="form-control" value="{{@$hospital[0]->hospital_name}}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                      <label for="inputEmail4" class="col-form-label">Hospital Address </label>
                                                        <input name="hospital_address" type="text" class="form-control" value="{{@$hospital[0]->hospital_address}}">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                      <label for="inputEmail4" class="col-form-label">Hospital Phone </label>
                                                        <input name="hospital_tel" type="text" class="form-control" value="{{@$hospital[0]->hospital_tel}}">
                                                    </div>
                                                </div>


                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                      <label for="inputEmail4" class="col-form-label">Hospital Email </label>
                                                        <input name="hospital_email" type="text" class="form-control" value="{{@$hospital[0]->hospital_email}}">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-12">
                                                    @if(@$hospital[0]->hospital_pic!="")
                                                    <img  id="imgnew" src="{{url('')}}/images/{{@$hospital[0]->hospital_pic}}" width="200px"/>
                                                    @endif
                                                    <br>
                                                    <input type="file" name="file">
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
