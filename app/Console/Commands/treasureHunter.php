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
        echo '########'."\n";
        echo '#......#'."\n";
        echo '#.###..#'."\n";
        echo '#...#.##'."\n";
        echo '#X#....#'."\n";
        echo '########'."\n";

        $name = $this->ask('up/down/left/right?');
        
        return ;
    }
}
