<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateUsers extends Command
{
    protected $signature = 'users:create {amount=1000000}';
    protected $description = 'Create a specified number of users';

    public function handle()
    {
        $amount = (int) $this->argument('amount');

        $chunkSize = 10000;
        $totalChunks = ceil($amount / $chunkSize);

        User::unguard();

        for ($i = 0; $i < $totalChunks; $i++) {
  
            $users = User::factory()->count($chunkSize)->make()->toArray();
            DB::table('users')->insert($users);
        }

        User::reguard();

        $this->info("Successfully created {$amount} users.");
    }
}
