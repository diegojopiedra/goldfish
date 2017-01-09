<?php

use Illuminate\Database\Seeder;
use App\GeneralConfiguration;

class GeneralConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GeneralConfiguration::create([
            'saturday_hour_opening'=>'08:00:00',
            'saturday_hour_closing'=>'15:45:00',
            'opening_hour_week'=>'07:00:00',
            'closing_hour_week'=>'18:45:00',
            'library_name'=>'Biblioteca Tacares',
            'next_update_time'=>'2018-01-01',
            ]);
    }
}
