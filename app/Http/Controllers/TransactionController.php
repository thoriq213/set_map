<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function form(){
        return view('form');
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

        return view('detail', $data);

    }
}
