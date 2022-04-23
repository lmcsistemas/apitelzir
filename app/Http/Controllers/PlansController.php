<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Plan;
use App\Models\Tariff;

class PlansController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { }

    public function index(){
        //$results = Tarifa::all();
        $results = DB::select("SELECT * FROM plans");
        return $results;        
    }

    public function getPlan($plan){

        if(strlen(trim($plan))==0){
            return response()->json([
                'error' => 'Plan is required'
            ], 404);
        }

        $results = Plan::where('plan', $plan)->first(['name','description', 'minutes', 'extra']);
        return response()->json($results, 200);
    }

    public function compute(Request $request){

        $params = $request->query();

        $origin     = (isset($params['origin'])) ? (int)$params['origin'] : "";
        $destination    = (isset($params['destination'])) ? (int)$params['destination'] : "";
        $plan      = (isset($params['plan'])) ? (int)$params['plan'] : "";
        $time      = (isset($params['time'])) ? $params['time'] : "";

        if(strlen(trim($origin))==0){
            return response()->json([
                'error' => 'Origem is required'
            ], 404);
        }
        if(strlen(trim($destination))==0){
            return response()->json([
                'error' => 'Destination is required'
            ], 404);
        }
        if(strlen(trim($time))==0){
            return response()->json([
                'error' => 'Time is required'
            ], 404);
        }

        $tariff = Tariff::where('origin', $origin)
                            ->where('destination', $destination)
                            ->first();

        if(empty($tariff)){
            return response()->json([
                'error' => 'Valores não encontrado, verifique nossos planos e tarifas'                
            ], 404);
        }

        $tariff = $tariff->price_minute;

        $total =  $time * $tariff;  

        $total = number_format($total, 2, ',', '');

        $retorno['noplan'] = "R$ ". $total;

        if(strlen(trim($plan)) > 0){
            $detail_plan = Plan::where('plan', $plan)->first(['name','description', 'minutes', 'extra']);

            $plan           = Plan::where('plan', $plan)->first();
            $minutes        = $plan->minutes;
            $namePlan       = $plan->name; 
            $extra          = $plan->extra;            
            $tariff_extra   = ($tariff + ($tariff * ($extra/100)));
            
            $time = (($time - $minutes) < 0 ) ? 0 : ($time - $minutes);
            $totalPlan =  $time * ($tariff_extra); 
            
            $totalPlan = number_format($totalPlan, 2, ',', '');

            $retorno['withplan'] = "R$ ". $totalPlan; 
            $retorno['detail_plan'] = $detail_plan;
        }     
       
        return response()->json($retorno, 200);
    }


}