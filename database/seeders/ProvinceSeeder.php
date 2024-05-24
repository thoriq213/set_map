<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('local')->get('/json/provinces.json');
        $data_array = json_decode($json, true);
        foreach($data_array as $value){
            DB::table('province')->insert([
                'id' => $value['id'],
                'name' => $value['name'],
                'alt_name' => $value['alt_name'],
                'latitude' => $value['latitude'],
                'longitude' => $value['longitude']
            ]);
        }
        //
    }
}
