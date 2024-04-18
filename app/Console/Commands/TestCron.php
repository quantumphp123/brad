<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plans:expire';

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

      $todayDate=Carbon::now();

      $check=DB::table('plan_history')->whereDate('valid_upto', '<=', $todayDate)->get();
  
    
      if($check)
      {

        DB::table('plan_history')->whereDate('valid_upto', '=', $todayDate)->update([
          'isActive'=>0,
        ]);

        foreach($check as $item)
        {

             DB::table('tbl_users')->where('id',$item->user_id)->update([
                   'payment_status'=>0,
                   'plan'=>null,    
             ]);
        }

      }
  
    }
}
