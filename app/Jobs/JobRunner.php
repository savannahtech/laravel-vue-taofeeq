<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Command;
use App\Models\CommandResult;

class JobRunner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $command;

    /**
     * Create a new job instance.
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check if the command is low priority
        // If true, check for high priority first
        $command = $this->command;
        if($command->type == 'A') {
            $command = Command::where([
                'type' => 'B',
                'status' => false
            ])->first();
        }

        // dummy processing
        $response = 10;
        for ($i = 0; $i < 100; $i++) {
            $response = rand() * $i;
        }

        // update command and save response for b
        $command->status = true;
        $command->save();

        if($command->type == 'B') {
            CommandResult::create([
                'data' => $response,
                'command_id' => $command->id
            ]);
        }
    }
}
