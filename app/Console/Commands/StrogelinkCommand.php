<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class StrogelinkCommand extends Command
{
    protected $signature = 'app:strogelink-command';
    protected $description = 'Command to run strogelink functionality';

    public function handle()
    {
        // Add your logic here
        $this->info('Strogelink command executed successfully!');
    }
}
