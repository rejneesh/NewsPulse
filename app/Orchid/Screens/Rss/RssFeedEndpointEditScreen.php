<?php

namespace App\Orchid\Screens\Rss;

use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use App\Models\RssFeedEndpoint;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;
use App\Models\Publication; // Make sure to import your model

class RssFeedEndpointEditScreen extends Screen
{
    public $name = 'Edit RSS Feed Endpoint';
    public $description = 'Edit details of the RSS Feed Endpoint';

    public function query(RssFeedEndpoint $rssendpoint): array
    {
        return [
            'rssendpoint' => $rssendpoint
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Save')
                ->icon('check')
                ->method('save'),
            // Button::make('Remove')
            //     ->icon('trash')
            //     ->confirm(__('Once deleted, all data will be permanently deleted.'))
            //     ->method('remove')
        ];
    }

    public function layout(): array
    {
        // Fetch publications for the dropdown
        $publications = Publication::pluck('publication_url')->toArray();
        $publicationOptions = array_combine($publications, $publications);

        return [
            Layout::rows([
                //     Select::make('rssendpoint.publication_url')
                //         ->title('Publication URL')
                //         ->options($publications) // Populate dropdown with publication URLs
                //         ->placeholder('Select a publication URL')
                //         ->required(), // Ensure this is required if the field should not be empty

                Select::make('rssendpoint.publication_url')
                    ->title('Publication URL')
                    ->options($publicationOptions) // Use formatted options
                    ->placeholder('Select a publication URL')
                    ->required(), // Ensure this is required if the field should not be empty

                Input::make('rssendpoint.endpoint')
                    ->title('Endpoint')
                    ->placeholder('Enter the RSS feed endpoint')
                    ->required(),

                Input::make('rssendpoint.note')
                    ->title('Note')
                    ->placeholder('Enter notes for the endpoint'),

                // Quill::make('rssendpoint.best_fetch_time')
                //     ->title('Best Fetch Time')
                //     ->placeholder('Enter the best fetch time'),

                // Input::make('rssendpoint.last_fetched')
                //     ->title('Last Fetched')
                //     ->type('datetime-local')
                //     ->placeholder('Enter the last fetched time')
            ])
        ];
    }

    public function save(Request $request, RssFeedEndpoint $rssendpoint)
    {

        $data = $request->validate([
            'rssendpoint.endpoint' => [
                'required',
                'string',
                'regex:/^\/.*/' // Custom validation to ensure endpoint starts with a '/'
            ],
            'rssendpoint.publication_url' => 'required|string|exists:publication,publication_url', // Validate existence
            'rssendpoint.note' => 'nullable|string',
        ], [
            'rssendpoint.endpoint.regex' => 'The endpoint must start with a forward slash "/".',
        ]);

        $rssendpoint->fill($data['rssendpoint']);
        $rssendpoint->save();

        Toast::info(__('RSS Feed Endpoint was saved'));
        return redirect()->route('platform.rssfeedendpoints');
    }

    public function remove(RssFeedEndpoint $rssendpoint)
    {
        $rssendpoint->delete();
        Toast::info(__('RSS Feed Endpoint was removed'));
        return redirect()->route('platform.rssfeedendpoints');
    }
}
