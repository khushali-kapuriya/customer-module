<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CountryStateCitySeeder extends Seeder {
    public function run() {
        $india = Country::firstOrCreate(['name'=>'India'], ['created_by'=>'system','created_on'=>now()]);
        $maha = State::firstOrCreate(['name'=>'Maharashtra','country_id'=>$india->id], ['state_code'=>27,'created_by'=>'system','created_on'=>now()]);
        $kar = State::firstOrCreate(['name'=>'Karnataka','country_id'=>$india->id], ['state_code'=>29,'created_by'=>'system','created_on'=>now()]);
        City::firstOrCreate(['name'=>'Mumbai','state_id'=>$maha->id], ['state_code'=>$maha->state_code,'country_id'=>$india->id,'created_by'=>'system','created_on'=>now()]);
        City::firstOrCreate(['name'=>'Bengaluru','state_id'=>$kar->id], ['state_code'=>$kar->state_code,'country_id'=>$india->id,'created_by'=>'system','created_on'=>now()]);
    }
}
