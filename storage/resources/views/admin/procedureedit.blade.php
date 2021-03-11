@extends('layouts.app')
@section('title', 'User edit - Telecorp')
@section('content')

      <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Staining</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
                        <!-- end row -->

                        {{--Form::open(['method'=>'put','route'=>['useredit',1]])--}}
                        {{--Form::open(['url'=>'useredit'])--}}
                        @if(isset($_GET['procedure_id']))
                          {{ Form::open(['method'=>'put','route'=>['admin_procedure.update',$_GET['procedure_id']],'enctype'=>'multipart/form-data'])}}
                          {{-- Form::open(['method'=>'put','url'=>'admin_procedureupdate', 'enctype'=>'multipart/form-data'] )--}}
                        @else
                          {{ Form::open(['url'=>'admin_procedure', 'enctype'=>'multipart/form-data'] )}}
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
                                                        <label for="inputEmail4" class="col-form-label">Staining Name </label>
                                                        <input name="staining_name" type="text" class="form-control" value="{{@$staining[0]->staining_name}}">
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
    <div class="row">
      <div class="col-12">
        <div class="card-box">

          <a href="{{url('')}}/admin_proceduresubedit/?procedure_id={{@$_GET['procedure_id']}}" class="btn btn-success">Add</a>
          <div class="table-rep-plugin">

              <table id="tech-companies-1" class="table table-striped">
                <thead>
                  <tr>
                    <th data-priority="1">Staining Sub</th>
                    <th width="40">Edit  </th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($stainingsub))
                    @foreach (@$stainingsub as $p)
                      <tr>
                        <th>{{ $p->stainingsub_name}}</th>
                        <td><a href="{{url('')}}/admin_proceduresubedit/?psub_id={{ $p->stainingsub_id }}&procedure_id={{@$_GET['procedure_id']}}" class="btn btn-icon waves-effect waves-light btn-info"> <i class="fa dripicons-document-edit"></i> </a></td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>

          </div>
          <div class="row">

          {{-- @$procedure->links() --}}

          </div>
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
