<?php

namespace App\Orchid\Layouts\Publication;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class PublicationEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     */
    protected function fields(): array
    {
        return [
            Input::make('publication.publication_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Publication Name')
                ->placeholder('Enter publication name'),

            Input::make('publication.publication_url')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Publication URL')
                ->placeholder('Enter publication URL'),

            Input::make('publication.publication_rank')
                ->type('number')
                ->required()
                ->title('Publication Rank')
                ->placeholder('Enter publication rank'),

            TextArea::make('publication.key_map')
                ->title('Key Map')
                ->rows(6)
                ->placeholder('Enter key map JSON data'),
        ];
    }
}
