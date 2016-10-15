<?php

use Illuminate\Database\Seeder;
use App\CopyPeriodicPublication;

class CopyPeriodicPublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<20;$i++) {
			CopyPeriodicPublication::create([
			'number'=>10+$i,
			'volume'=>$i+2,
			'publication_date'=>'2004-01-'. (10+$i),
			'periodic_publication_id'=>$i+1,
			'loanables_id'=>$i+1,
			]);
		}
    }
}
