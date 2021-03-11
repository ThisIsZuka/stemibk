<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Items;
use Illuminate\Http\Request;
use Session;
use App\Patient;
use DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Auth;

class DashboardController extends Controller
{

    public function ss (){

        // return view('patient.dashboard');
    }

     public function didoprocess(Request $request)
     {
        // session_start();
        // $id=session('user')->us_hos_refno;
        // $today=Carbon::now()->todateString();
        // // dd($today);
        // //$dd_dash = DB::table('stemi_request')->where('rq_host_hos_refno','=',$_SESSION['user']->us_hos_refno)->orderby('rq_id','desc')->get();
        // $dd_dash = DB::table('stemi_dashboard')->where('id_clien','=',$id)->where('date_event','=',$today)->get();
        
        // // $create=$dd_dash[0]->rq_time_create;
    
        
        // // $create->diffInMinutes();

        // // // dd($create);



        // $getAverageCompletionTime = DB::table('stemi_dashboard')
        // ->select(DB::raw(("AVG(TIME_TO_SEC(TIMEDIFF(rq_time_create, rq_time_sent))) AS timediff")))
        // ->where('id_clien','=', $id)
        // ->where('date_event','=',$today)
        // ->get();
     
        // $averageCompletionTime = CarbonInterval::seconds((int)$getAverageCompletionTime[0]->timediff)
        // ->cascade()
        // ->forHumans();
        // dd($getAverageCompletionTime);



        // $data['dido']       = 0;
        // $data['referral']   = 0;
        // $data['reponses']   = 0;
        // $data['tracking']   = 0;

        // foreach($dd_dash as $date_dash){
        //     // dd($date_dash);
        //     $create  = $date_dash->rq_time_create;
        //     // $create->toTimeStrung();
        //     // $create->diffInMinutes();
        //     dd($create);
        //     $end    = $date_dash->rq_time_end;
        //     $start  = $date_dash->rq_time_sent;
        //     $step4  = $date_dash->rq_time_ekgviews;
            
        //     $step5  = $date_dash->rq_time_hosresponse;
        //     $from   = Carbon::parse($end);
        //     // $to     = Carbon::parse($start);
        //     // $num4   = Carbon::parse($step4);
        //     // $num2   = Carbon::parse($step2);
        //     // $num5   = Carbon::parse($step5);
        //     dd($from);
        //     $data['dido']       = $data['dido']+$to->diffInMinutes($from);
        //     $data['referral']   = $data['referral']+$to->diffInMinutes($num4);
        //     $data['reponses']   = $data['reponses']+$num2->diffInMinutes($from);
        //     $data['tracking']   = $data['tracking']+$num5->diffInMinutes($from);
        // }




     return view('patient.dashboard',$data);
     }


     public function search(Request $request)
     {

     }

    public function create()
    {



    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {

    }

    public function edit($id)
    {


    }


    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        //
    }
}
