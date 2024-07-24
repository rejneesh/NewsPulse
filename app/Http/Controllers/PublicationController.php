<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class PublicationController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Publication $publication)
    {
        $publication->delete();

        Toast::info(__('Publication was removed'));

        return redirect()->route('platform.publication');
    }
}
