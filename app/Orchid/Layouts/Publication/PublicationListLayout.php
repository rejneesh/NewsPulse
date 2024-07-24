<?php

namespace App\Orchid\Layouts\Publication;

use App\Models\Publication;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PublicationListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'publications';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('publication_name', 'Name')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Publication $publication) {
                    return Link::make($publication->publication_name)
                        ->route('platform.publication.edit', $publication);
                }),

            TD::make('publication_url', 'URL')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('publication_rank', 'Rank')
                ->sort()
                ->filter(TD::FILTER_NUMERIC),

            TD::make('created_at', 'Created')
                ->sort()
                ->render(function (Publication $publication) {
                    return $publication->created_at ? $publication->created_at->format('Y-m-d H:i:s') : 'N/A';
                }),
            TD::make('updated_at', 'Updated')
                ->sort()
                ->render(function (Publication $publication) {
                    return $publication->updated_at ? $publication->created_at->format('Y-m-d H:i:s') : 'N/A';
                }),

        ];
    }
}
