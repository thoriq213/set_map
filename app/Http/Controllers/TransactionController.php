<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Provinces;
use App\Models\Village;
use Illuminate\Http\Request;
class TransactionController extends Controller
{
    public function form(){
        $data['provinces'] = Provinces::all();
        return view('form', $data);
    }

    public function get_city(Request $request){
        $city = City::where('province_id', $request->province_id)->get();
        echo json_encode($city);
    }

    public function get_district(Request $request){
        $district = District::where('city_id', $request->city_id)->get();
        echo json_encode($district);
    }

    public function get_village(Request $request){
        $village = Village::where('district_id', $request->district_id)->get();
        echo json_encode($village);
    }

    public function transaction(Request $request){
        $data['total_jasa'] = 0;
        if(isset($request->jasa)){
            foreach ($request->jasa as $key => $value) {
                $data['total_jasa'] += $value;
            }
        }
        $data['longitude'] = $request->longitude;
        $data['latitude'] = $request->latitude;
        $data['province'] = Provinces::where('id', $request->province)->first();
        $data['city'] = City::where('id', $request->city)->first();
        $data['district'] = District::where('id', $request->district)->first();
        $data['village'] = Village::where('id', $request->village)->first();
        $data['detail'] = $request->detail;

        // dd($data);

        return view('detail', $data);

    }
}
