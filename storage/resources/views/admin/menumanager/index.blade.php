    @extends('layouts.app')
    @section('title', 'User - Telecorp')
    @section('content')

     <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title float-left">Article</h4>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


                        <a href="{{url('')}}/menu_manager/create" class="btn btn-secondary btn-rounded waves-light waves-effect w-md">Add</a>
                        <div class="clearfix"></div>
                        <br />

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="table-rep-plugin">
                                            <table id="tech-companies-1" class="table table-striped" data-add-focus-btn="">
                                                <thead>
                                                <tr>
                                                    <th width="200">Name</th>
                                                    <th data-priority="1">Type</th>
                                                    <th width="40">Edit  </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                @forelse ($menu as $m)
                                                  <tr>
                                                        
                                                        <td>{{ $m->menu_name}}</td>
                                                        <td>{{ $m->menu_type}}</td>
                                                        <td><a href="{{url('')}}/menu_manager/{{$m->menu_id}}" class="btn btn-icon waves-effect waves-light btn-info"> <i class="fa dripicons-document-edit"></i> </a></td>
                                                  </tr>
                                                @empty
                                                @endforelse

                                                </tbody>
                                            </table>


                                    </div>
                                    <div class="row">
                                        @php /*
                                      {{ $menu->links() }}
                                        */
                                        @endphp
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
