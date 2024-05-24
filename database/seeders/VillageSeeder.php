<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('local')->get('/json/villages.json');
        $data_array = json_decode($json, true);
        foreach($data_array as $value){
            DB::table('village')->insert([
                'id' => $value['id'],
                'district_id' => $value['district_id'],
                'name' => $value['name'],
                'alt_name' => $value['name'],
                'latitude' => $value['latitude'],
                'longitude' => $value['longitude']
            ]);
        }
        //
    }
}
