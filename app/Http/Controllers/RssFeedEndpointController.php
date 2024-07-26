<?php

namespace App\Http\Controllers;

use App\Models\RssFeedEndpoint;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class RssFeedEndpointController extends Controller
{

public function rssFeedEndpointList()
    {
        $rssFeedEndpoints = RssFeedEndpoint::latest()->take(20)->get();
        
        return $rssFeedEndpoints;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  RssFeedEndpoint  $rssendpoint
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Request $request, PublicationRssFeedEndpoint $rssendpoint)
    // {
    //     $rssendpoint->delete();

    //     Toast::info(__('RSS Feed Endpoint was removed'));

    //     return redirect()->route('platform.rssfeedendpoints');
    // }
}
?>
