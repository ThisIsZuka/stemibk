@extends('layouts.app')
@section('title', 'User - Telecorp')
@section('content')

 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title float-left">Procedure</h4>

                                    {{-- <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="#">Administrator</a></li>
                                        <li class="breadcrumb-item"><a href="#">User</a></li>
                                    </ol> --}}

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <a href="{{url('')}}/admin_procedure/create" class="btn btn-secondary btn-rounded waves-light waves-effect w-md">Add</a>
                        <div class="clearfix"></div>
                        <br />

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="table-rep-plugin">
                                            <table id="tech-companies-1" class="table table-striped" data-add-focus-btn="">
                                                <thead>
                                                <tr>
                                                    <th data-priority="1">Procedure</th>
                                                    <th width="40">Edit  </th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @forelse ($procedure as $p)
                                                  <tr>
                                                      <th>{{ $p->procedure_name}}</th>
                                                      <td><a href="{{url('')}}/admin_procedure/{{$p->procedure_id}}/?procedure_id={{ $p->procedure_id }}" class="btn btn-icon waves-effect waves-light btn-info"> <i class="fa dripicons-document-edit"></i> </a></td>
                                                  </tr>
                                                @empty

                                                @endforelse



                                                </tbody>
                                            </table>


                                    </div>
                                    <div class="row">
                                      {{ $procedure->links() }}
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
