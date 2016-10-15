<?php

use Illuminate\Database\Seeder;
use App\Student; 

class StudentSeeder extends Seeder
{
    public function __construct()
    {
        $this->nums = [];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::Create([
                'license' => "B35319",
                'user_id' =>  1,
                ]);
        for($i=1; $i<20;$i++) {
             Student::Create([
                'license' => ((rand(0,1))?"A":"B") . $this->getNum($this->nums),
                'user_id' => $i + 1,
             	]);
        }
    }

    public function getNum($nums)
    {
        do{
            $num = rand(0,69999);
            $sNum = $this->complete($num,5,$nums);    
        }while (in_array($sNum, $nums));
        
        array_push($nums, $sNum);
        return $sNum;
    }


    public function complete($num, $length, $nums)
    {
        $string = "";
        $numLength = strlen($num);
        for ($i=0; $i < ($length-$numLength); $i++) { 
            $string .= "0";
        }
        $string .= $num;
        return $string;
    }   
}
