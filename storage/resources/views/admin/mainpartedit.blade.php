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


    @if(isset($_GET['procedure_id']))
      {{ Form::open(['method'=>'put','url'=>'admin_mainpartadd', 'enctype'=>'multipart/form-data'] )}}
      <input type="hidden" name="procedure_id" value="{{@$_GET['procedure_id']}}">
    @else
      {{ Form::open(['method'=>'put','url'=>'admin_mainpartupdate', 'enctype'=>'multipart/form-data'] )}}
      <input type="hidden" name="mainpart_id" value="{{@$_GET['mainpart_id']}}">
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title"><b>Main Part</b></h4>
                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <input name="mainpart_name" type="text" class="form-control" value="{{@$mainpart[0]->mainpart_name}}">
                                    <input name="procedure_id" type="hidden" value="{{$_GET['procedure_id']}}" >
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close()}}

                        {{--#####          #####--}}
                        <div class="row">
                          <div class="col-12">
                            <div class="card-box">
                              <div class="table-rep-plugin">

                                <a href="{{url('')}}/admin_mpproblemedit/?mainpart_id={{@$_GET['mainpart_id']}}" class="btn btn-success">Add</a>
                                  <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th data-priority="1">Main problem</th>
                                        <th width="40">Edit  </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach (@$mainproblem as $p)
                                        <tr>
                                          <th>{{ $p->mainproblem_name}}</th>
                                          <td><a href="{{url('')}}/admin_mpproblemedit/?mainproblem_id={{ $p->mainproblem_id }}&mainpart_id={{$_GET['mainpart_id']}}&procedure_id={{$_GET['procedure_id']}}" class="btn btn-icon waves-effect waves-light btn-info"> <i class="fa dripicons-document-edit"></i> </a></td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>

                              </div>
                              <div class="row">
                              {{ $mainproblem->links() }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end row -->

                        {{--#####          #####--}}
                        <div class="row">
                          <div class="col-12">
                            <div class="card-box">
                              <div class="table-rep-plugin">

                                  <a href="{{url('')}}/admin_mainpartsubedit/?mainpart_id={{@$_GET['mainpart_id']}}" class="btn btn-success">Add</a>
                                  <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th data-priority="1">Sub-main part</th>
                                        <th width="40">Edit  </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach (@$mainpartsub as $p)
                                        <tr>
                                          <th>{{ $p->mainpartsub_name}}</th>
                                          <td><a href="{{url('')}}/admin_mainpartsubedit/?mainpartsub_id={{ $p->mainpartsub_id }}&mainpart_id={{$_GET['mainpart_id']}}&procedure_id={{$_GET['procedure_id']}}" class="btn btn-icon waves-effect waves-light btn-info"> <i class="fa dripicons-document-edit"></i> </a></td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                              </div>
                              <div class="row">
                              {{ $mainpartsub->links() }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end row -->

                        {{--#####          #####--}}
                        <div class="row">
                          <div class="col-12">
                            <div class="card-box">
                              <div class="table-rep-plugin">

                                  <a href="{{url('')}}/admin_smgledit/?mainpart_id={{@$_GET['mainpart_id']}}" class="btn btn-success">Add</a>
                                  <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th data-priority="1">Sub main Gastro Lesion</th>
                                        <th width="40">Edit  </th>
                                      </tr>
                                    </thead>
                                    <tbody>


                                      @foreach (@$mainsubgl as $p)
                                        <tr>
                                          <th>{{ $p->mainsubgl_name}}</th>
                                          <td><a href="{{url('')}}/admin_smgledit/?mainsubgl_id={{ $p->mainsubgl_id }}&mainpart_id={{$_GET['mainpart_id']}}&procedure_id={{$_GET['procedure_id']}}" class="btn btn-icon waves-effect waves-light btn-info"> <i class="fa dripicons-document-edit"></i> </a></td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>

                              </div>
                              <div class="row">
                              {{ $mainsubgl->links() }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end row -->






                    </div> <!-- container -->


                <footer class="footer text-right">
                    © Telecorp.
                </footer>

@endsection
