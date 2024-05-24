<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('local')->get('/json/districts.json');
        $data_array = json_decode($json, true);
        foreach($data_array as $value){
            DB::table('district')->insert([
                'id' => $value['id'],
                'city_id' => $value['regency_id'],
                'name' => $value['name'],
                'alt_name' => $value['alt_name'],
                'latitude' => $value['latitude'],
                'longitude' => $value['longitude']
            ]);
        }
        //
    }
}
