<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UserExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get expired users';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $users=User::where('expire','=',0)->get();
        foreach($users as $user){
        $user->update(['expire'=>1]);
        }
    }
}
