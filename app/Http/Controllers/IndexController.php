<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Jobs\JobRunner;
use App\Models\Command;
use App\Models\CommandResult;
use Auth;

class IndexController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Index');
    }

    public function execute(Request $request)
    {
        $request->validate([
            'command' => 'required',
            'type' => 'required|in:a,b'
        ]);

        // insert into queue
        $command = Command::create([
            'type' => $request->type,
            'command' => $request->command,
        ]);

        // process command (s)
        JobRunner::dispatch($command)
            ->delay(now()->addSeconds($command->type == 'a' ? 30 : 15));

        //
        return response()->json([
            'state' => true,
            'message' => 'Command submitted succssfully'
        ]);
    }

    public function loadData()
    {
        $model = CommandResult::first();

        // delete the response
        if($model) $model->delete();

        //
        return response()->json([
            'state' => true,
            'data' => $model
        ]);
    }
}
