@extends('layouts.app')
@section('title', 'User - Telecorp')
@section('content')

 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title float-left">Scope</h4>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <a href="{{url('')}}/admin_scopeedit" target="_blank" class="btn btn-secondary btn-rounded waves-light waves-effect w-md">Add</a>
                        <div class="clearfix"></div>
                        <br />

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="table-rep-plugin">
                                            <table id="tech-companies-1" class="table table-striped" data-add-focus-btn="">
                                                <thead>
                                                <tr>
                                                    <th data-priority="1">Scope</th>
                                                    <th width="40">Edit  </th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach ($scope as $s)
                                                  <tr>
                                                      <th>{{ $s->scope_name}}</th>
                                                      <td>
                                                        <a href="{{url('')}}/admin_scopeedit/?id={{ $s->scope_id }}" class="btn btn-icon waves-effect waves-light btn-info">
                                                          <i class="fa dripicons-document-edit"></i>
                                                        </a>
                                                      </td>
                                                  </tr>
                                                @endforeach
                                                </tbody>
                                            </table>


                                    </div>
                                    <div class="row">
                                      {{ $scope->links() }}
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
