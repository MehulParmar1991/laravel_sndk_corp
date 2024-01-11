<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Country;
use App\Models\City;
use App\Models\Area;

class CountryCityAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Pakistan Seeding Data


        $country = Country::create(['name' => 'Pakistan']);
  
        $city = City::create(['country_id' => $country->id, 'name' => 'Karachi']);
  
        Area::create(['city_id' => $city->id, 'name' => 'Defence']);
        Area::create(['city_id' => $city->id, 'name' => 'Clifton']);

        

        // US Seeding Data


        $country = Country::create(['name' => 'United State']);
  
        $city = City::create(['country_id' => $country->id, 'name' => 'Texas']);
  
        Area::create(['city_id' => $city->id, 'name' => 'Houston']);
        Area::create(['city_id' => $city->id, 'name' => 'Dallas']);
  
        
        // Turkey Seeding Data 


        $country = Country::create(['name' => 'Turkey']);
  
        $city = City::create(['country_id' => $country->id, 'name' => 'Istanbul']);
  
        Area::create(['city_id' => $city->id, 'name' => 'Fatih']);
        Area::create(['city_id' => $city->id, 'name' => 'Kartal']);
    }
}
