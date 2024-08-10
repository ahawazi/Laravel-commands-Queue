<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InsertUsers extends Command
{
    protected $signature = 'insert:users';
    protected $description = 'Insert 1 million users into the database';

    public function handle()
    {
        $batchSize = 10000;
        $totalBatches = 10000;

        User::withoutEvents(function () use ($batchSize, $totalBatches) {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::statement('ALTER TABLE users DISABLE KEYS;');

            DB::transaction(function () use ($batchSize, $totalBatches) {
                for ($i = 0; $i < $totalBatches; $i++) {
                    $users = User::factory()->count($batchSize)->make()->toArray();
                    User::insert($users);

                    $this->info('Inserted batch ' . ($i + 1) . '/' . $totalBatches);
                }
            });

            DB::statement('ALTER TABLE users ENABLE KEYS;');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        });

        $this->info('1 million users inserted successfully!');
    }
}