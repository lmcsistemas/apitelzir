<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tariff;

class TariffsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { }

    public function index(){
        //$results = Tarifa::all();
        $results = DB::select("SELECT *,  'R$ ' || trim(to_char(price_minute, '9999999999D99' )) as price_minute FROM tariffs");
        return $results;        
    }

    public function getTariffs(Request $request){
        $params = $request->query();
        $origin = $params['origin'];
        $destination = $params['destination'];
        $results = Tariff::where('origin', $origin)
                            ->where('destination', $destination)
                            ->first(['tariff','price_minute']);
        return response()->json($results, 200);
        
    }
}