<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:data {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get the data of user';

    public function handle()
    {
        if($this->argument('id')) {
            $user = User::whereId($this->argument('id'))
            ->get(['name', 'id', 'salery', 'is_admin', 'status']);

            if(count($user) > 0) {
                $this->table(['name', 'id', 'salery', 'is_admin', 'status'], $user);
            }else{
                $this->error('user not found');
            }
        }else{
            $users = User::get(['name', 'id', 'salery', 'is_admin', 'status']);

            $this->table(['name', 'id', 'salery', 'is_admin', 'status'], $users);

            $this->info('user date');
        }
    }
}
