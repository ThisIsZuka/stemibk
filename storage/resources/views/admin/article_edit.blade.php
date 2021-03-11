	@extends('layouts.app')
	@section('title', 'User edit - Telecorp')
	@section('content')

		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<h4 class="page-title float-left">เพิ่มรูปลงระบบ</h4>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>

	    @if(isset($_GET['id']))
	    {{ Form::open(['method'=>'put','route'=>['admin_article.update',$_GET['id']],'enctype'=>'multipart/form-data'])}}
	    @else
	    {{ Form::open(['action'=>'AdminArticle@store', 'enctype'=>'multipart/form-data'] )}}
	    @endif
	    <input type="hidden" name="id" value="{{@$_GET['id']}}">
	    <div class="row">
	        <div class="col-12">
	            <div class="card-box">
	                <h4 class="m-t-0 header-title"><b>เพิ่มรูป</b></h4>
	                <div class="row">
	                    <div class="col-12">
	                        <div class="p-20">
	                          	<div class="row">
	                            	<div class="col-12">
	                          			@if(@$case[0]->article_pic!="")
	                          				<img  id="imgnew" src="{{url('')}}/pic/{{@$case[0]->article_pic}}" width="200px"/>
	                          			@endif
	                          			<br>
	                          			<input type="file" name="file">
	                        		</div>
	                      		</div>

	                            <div class="form-row">
	                                <div class="form-group col-md-12">
	                                    <label for="inputEmail4" class="col-form-label">Title </label>
	                                    <input name="article_title" type="text" class="form-control" value="{{@$article[0]->article_title}}">
	                                </div>
	                            </div>


	                            <div class="form-row">
	                                <div class="form-group col-md-12">
	                                    <label for="inputEmail4" class="col-form-label">Detail </label>
	                                    <input name="article_detail" type="text" class="form-control" value="{{@$article[0]->article_detail}}">
	                                </div>
	                            </div>

	                            <div class="form-row">
	                                <div class="form-group col-md-12">
	                                	<textarea class="form-control" id="summary-ckeditor" name="article_description">{{@$article[0]->article_description}}</textarea>
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

		<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
		<script>
		    CKEDITOR.replace( 'summary-ckeditor',    {
		        filebrowserBrowseUrl : '{{url('')}}/ckfinder/samples/full-page-open.html',
		        filebrowserUploadUrl : '{{url('')}}/uploader/upload.php'
		    } );
		</script>
	@endsection











