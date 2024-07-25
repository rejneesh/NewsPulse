<?php

namespace App\Http\Controllers;

use App\Models\PublicationRssFeedEndpoint;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class RssFeedEndpointController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  RssFeedEndpoint  $rssendpoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PublicationRssFeedEndpoint $rssendpoint)
    {
        $rssendpoint->delete();

        Toast::info(__('RSS Feed Endpoint was removed'));

        return redirect()->route('platform.rssfeedendpoints');
    }
}
?>
