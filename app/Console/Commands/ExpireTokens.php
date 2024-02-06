<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:expire';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire tokens older than 1 minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expirationTime = now()->subMinutes(1);

        DB::table('personal_access_tokens')
            ->where('created_at', '<', $expirationTime)
            ->update(['expires_at' => now()]);

        $this->info('Tokens expired successfully.');
    }
}
