@extends('app')
@section('content')
<style type="text/css">
   .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
     color: #ffffff;
     background-color: #ca004e;
     border-color: #dee2e6 #dee2e6 #fff;
  }
  a{
   color: #000;
}
</style>
<div class="container-fluid">
   <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
     <a class="nav-link active txt" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">รพ. ในโซน</a>
  </li>
  <li class="nav-item">
     <a class="nav-link txt" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">รพ. นอกโซน</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
 <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    {!!$hospital_list!!}
 </div>
 <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
   {!!$out_zone_hospital_list!!}
 </div>
</div>
</div>
@endsection