<?php

use Illuminate\Database\Seeder;
use App\Brand;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i < 20; $i++){
        	Brand::create([

        		'name'    =>  'brand_'.$i,
        		]);

        }
    }
}
