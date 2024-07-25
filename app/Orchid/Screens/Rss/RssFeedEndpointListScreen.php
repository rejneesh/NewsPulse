<?php

namespace App\Orchid\Screens\Rss;

use Orchid\Screen\Screen;
use App\Models\RssFeedEndpoint;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use App\Orchid\Layouts\Rss\RssFeedEndpointListLayout;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class RssFeedEndpointListScreen extends Screen
{
    public $name = 'RSS Endpoints';
    public $description = 'List of RSS Feed Endpoints';

    public function query(): array
    {
        return [
            'rssFeedEndpoints' => RssFeedEndpoint::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Add')
                ->icon('plus')
                ->route('platform.rssfeedendpoint.create')
        ];
    }

    public function layout(): array
    {
        return [
            RssFeedEndpointListLayout::class
        ];
    }

    public function remove(Request $request): void
    {
        $endpoint = RssFeedEndpoint::findOrFail($request->get('id'));
        $endpoint->delete();
        Toast::info(__('RSS Feed Endpoint was removed'));
    }
}
?>
