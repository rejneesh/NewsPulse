<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RssFeedEndpointController;
use App\Http\Controllers\FeedController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to NewsPulse API']);
});
Route::get('/rss-feed-endpoint', [RssFeedEndpointController::class, 'rssFeedEndpointList']);
Route::get('/rss-feed', [FeedController::class, 'rssFeedList']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
