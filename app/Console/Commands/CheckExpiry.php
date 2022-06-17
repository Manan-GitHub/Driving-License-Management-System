<?php

namespace App\Console\Commands;

use App\Mail\ExpiryMail;
use App\Models\Application;
use App\Models\License;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the expiry date of license and emails the users ';

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
        foreach(License::all() as $license){
            if(Carbon::now() > $license->expiry_date){
                $license->status = false;
                $license->save();
                $details = [
                    'title' => 'Attention!',
                    'body' => 'Your driving has expired. Kindly get it renewed or apply for a new one'
                ];
                
                Mail::to($license->user->email)->send(new ExpiryMail($details));
                echo ('email sent');
            }
        }

        foreach(Application::all() as $application){
            if($application->payment_status == false){
                $application->delete();
            }
        }
        
    }
}
