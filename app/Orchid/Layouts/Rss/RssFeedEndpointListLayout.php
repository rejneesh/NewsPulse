<?php

namespace App\Orchid\Layouts\Rss;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use App\Models\RssFeedEndpoint;
use Orchid\Screen\Actions\DropDown;

class RssFeedEndpointListLayout extends Table
{
    protected $target = 'rssFeedEndpoints';

    protected function columns(): array
    {
        return [
            TD::make('combined', 'Publication & Endpoint')
                ->sort() // Enables sorting
                ->filter(TD::FILTER_TEXT)
                ->render(function ($record) {
                    return $record->publication_url .  $record->endpoint;
                }),


            TD::make('note', 'Note')->sort()->filter(TD::FILTER_TEXT),

            TD::make('last_fetched', 'Last Fetched')
                ->sort()
                ->filter(TD::FILTER_DATE_RANGE)
                ->render(function ($record) {
                    return $record->last_fetched ? $record->last_fetched->diffForHumans() : 'N/A';
                }),

            TD::make('last_fetched_status', 'Fetch Status')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function ($record) {
                    return $record->last_fetched_status; // Simply show the status number
                }),

            // TD::make('created_at', 'Created')->sort()->filter(TD::FILTER_DATE_RANGE),

            // TD::make('updated_at', 'Updated')->sort()->filter(TD::FILTER_DATE_RANGE),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('70px')
                ->render(function (RssFeedEndpoint $endpoint) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.rssfeedendpoint.edit', ['rssendpoint' => $endpoint->rss_feed_endpoint_id])
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once deleted, all data will be permanently deleted.'))
                                ->method('remove', [
                                    'id' => $endpoint->rss_feed_endpoint_id,
                                ]),
                        ]);
                }),
        ];
    }
}
