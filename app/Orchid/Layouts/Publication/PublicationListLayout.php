<?php

namespace App\Orchid\Layouts\Publication;

use App\Models\Publication;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Button;

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
                        ->route('platform.publication.edit', ['publication' => $publication->publication_id]);
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
                    return $publication->updated_at ? $publication->updated_at->format('Y-m-d H:i:s') : 'N/A';
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('70px')
                ->render(function (Publication $publication) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.publication.edit', ['publication' => $publication->publication_id])
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the publication is deleted, all of its resources and data will be permanently deleted. Before deleting, please download any data or information you wish to retain.'))
                                ->method('remove', [
                                    'id' => $publication->publication_id,
                                ]),
                        ]);
                }),
        ];
    }
}
