<?php

use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/dispatch-job', [QueueController::class, 'dispatchJob']);
Route::get('/dispatch-multiple-jobs', [QueueController::class, 'dispatchMultipleJobs']);


Route::get('/test-queue', function () {
    \App\Jobs\LogMessageJob::dispatch('Test message from browser route');
    return 'Job dispatched! Check the queue worker.';
});


