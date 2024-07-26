<?php

namespace App\Http\Controllers;

use App\Models\RssFeed;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class FeedController extends Controller
{

    public function rssFeedList()
    {
        $rssFeed = RssFeed::latest()->take(20)->get();

        return $rssFeed;
    }
}
