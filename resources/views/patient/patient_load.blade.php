

<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
 
<link href="{{URL::asset('stemi_css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('font_kanit/stylesheet.css')}}" rel="stylesheet" />
<script src="{{url('')}}/stemi_js/jquery-3.4.1.min.js"></script>
<script src="{{url('')}}/stemi_js/bootstrap.min.js"></script>

<style>
   .wrapper > ul#results li {
     margin-bottom: 2px;
     background: #e2e2e2;
     padding: 20px;
     width: 97%;
     list-style: none;
   }
   .ajax-loading{
     text-align: center;
   }
</style>
</head>
  
<body>
  
  <div class="container">
   <div class="wrapper">
    <ul id="results"><!-- results appear here --></ul>
     <div class="ajax-loading"><img src="{{ asset('images/loading.gif') }}" /></div>
   </div>
  </div>
</body>
</html>


<script>
   var SITEURL = "{{ url('') }}";
   var page = 1; //track user scroll as page number, right now page number is 1
   load_more(page); //initial content load
   $(window).scroll(function() { //detect page scroll
      if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
      page++; //page number increment
      load_more(page); //load content   
      }
    });     
    function load_more(page){
        $.ajax({
           url: SITEURL + "/patient_load?page=" + page,
           type: "get",
           datatype: "html",
           beforeSend: function()
           {
              $('.ajax-loading').show();
            }
        })
        .done(function(data)
        {
            if(data.length == 0){
            console.log(data.length);
            //notify user if nothing to load
            $('.ajax-loading').html("No more records!");
            return;
          }
          $('.ajax-loading').hide(); //hide loading animation once data is received
          $("#results").append(data); //append data into #results element          
           console.log('data.length');
       })
       .fail(function(jqXHR, ajaxOptions, thrownError)
       {
          alert('No response from server');
       });
    }
</script>