    @extends('layouts.app')
    @section('title', 'User edit - Telecorp')
    @section('content')

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
@if(isset($menu))                    
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
    ลบ
</button>
@endif
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


    @if(isset($menu))
        {{Form::open(['method'=>'put','route'=>['menu_manager.update',$menu->menu_id]])}}
    @else
        {{Form::open(['url'=>'menu_manager'])}}
    @endif
        <div class="row">
            <div class="col-12">
                <div class="card-box">


                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">



                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="col-form-label">ประเภท </label>
                                        
                                            <select class="form-control" name="menu_type" value="{{@$menu->menu_type}}">
                                              <option value="ผลงานวิจัยเผยแพร่">ผลงานวิจัยเผยแพร่</option>
                                              <option value="สิทธิบัตร/นวัตกรรม/รางวัลวิจัย">สิทธิบัตร/นวัตกรรม/รางวัลวิจัย</option>
                                              <option value="ทุนวิจัย">ทุนวิจัย</option>
                                            </select>


                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="col-form-label">ซื่อเรื่อง </label>
                                        <input name="menu_name" type="text" class="form-control" value="{{@$menu->menu_name}}">
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="col-form-label">ลำดับ </label>
                                        <input name="menu_order" type="text" class="form-control" value="{{@$menu->menu_order}}">
                                    </div>
                                </div>         

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="col-form-label">สถานะ </label>
    
<select class="form-control" name="menu_status" value="{{@$menu->menu_order}}">
  <option value="0">เผยแพร่</option>
  <option value="1">ไม่เผยแพร่</option>
</select>


                                    </div>
                                </div>                                                          

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4" class="col-form-label">รายละเอียด </label>
                                        <textarea class="form-control" id="summary-ckeditor" name="menu_text">{{@$menu->menu_text}}</textarea>
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

        <footer class="footer text-right">
            © Telecorp.
        </footer>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

        {{ Form::open(['method'=>'put','route'=>['menu_manager.update',Request::segment(2)],'enctype'=>'multipart/form-data'])}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <input type="hidden" name="del_id" value="{{Request::segment(2)}}">
            <p>ต้องการจะลบ Menu นี้หรือไม่</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Close</button>
            </div>
        {{Form::close()}}

    </div>

  </div>
</div>





        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script>
            CKEDITOR.replace( 'summary-ckeditor',    {
                filebrowserBrowseUrl : '{{url('')}}/ckfinder/samples/full-page-open.html',
                filebrowserUploadUrl : '{{url('')}}/uploader/upload.php'
            } );
        </script>
    @endsection











