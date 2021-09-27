<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class treasureHunter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'treasure:hunter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $location = '3,1';

    private $obstacle = ['3,2','2,4','2,6','1,2','1,3','1,4'];
    
    private $endGame = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $coordinateChecker = true;

        while($coordinateChecker){
            $treasureX = rand(1,6);
            $treasureY = rand(0,3);
    
            $treasureCordinate = $treasureY.','.$treasureX;
            if(!in_array($treasureCordinate,$this->obstacle)) $coordinateChecker = false;
        }


        while (!$this->endGame) {
            $this->remap($treasureCordinate);

            $name = $this->ask('up/down/left/right?');
            $arrayLoc = explode(',',$this->location);
            switch ($name) {
                case 'up':
                    $arrayLoc[0] = $arrayLoc[0] - 1;    
                    break;
                case 'down':
                    $arrayLoc[0] = $arrayLoc[0] + 1; 
                    break;
                case 'left':
                    $arrayLoc[1] = $arrayLoc[1] - 1;
                    break;
                case 'right':
                    $arrayLoc[1] = $arrayLoc[1] + 1;
                    break;
                
                default:
                    # code...
                    break;
            }
            $this->location = implode(',',$arrayLoc);
        }
        
        return ;
    }

    public function remap($treasureCordinate){
       
        
        echo '########'."\n";
        for ($y=0;$y < 4; $y++) { 
            for ($x=0;$x <8 ; $x++) { 
                if($this->location == $y.','.$x){
                    echo "x";
                }elseif($treasureCordinate == $y.','.$x && !$this->endGame){
                    echo "$";
                }elseif($x == 0 || $x == 7 || in_array($y.','.$x,$this->obstacle)){
                    echo "#";
                }else{
                    echo ".";
                }

            }
            echo "\n";
        }
        echo '########'."\n";
        if($treasureCordinate == $this->location){
            $this->endGame = true;
        }

    }
}
