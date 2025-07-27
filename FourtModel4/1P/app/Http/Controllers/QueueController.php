<?php

namespace App\Http\Controllers;

use App\Jobs\LogMessageJob;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function dispatchJob(Request $request)
    {
        $message = $request->input('message', 'Default test message from queue');


        LogMessageJob::dispatch($message);

        return response()->json([
            'status' => 'success',
            'message' => 'Job dispatched to queue',
            'data' => $message
        ]);
    }

    public function dispatchMultipleJobs()
    {
        $messages = [
            'First message from queue',
            'Second message from queue',
            'Third message from queue',
            'Fourth message from queue',
            'Fifth message from queue'
        ];

        foreach ($messages as $message) {
            LogMessageJob::dispatch($message);
        }

        return response()->json([
            'status' => 'success',
            'message' => count($messages) . ' jobs dispatched to queue'
        ]);
    }
}
