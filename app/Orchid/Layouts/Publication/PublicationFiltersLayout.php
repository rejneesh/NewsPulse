<?php

namespace App\Orchid\Layouts\Publication;

use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PublicationFiltersLayout extends Selection
{
    /**
     * @return array
     */
    public function filters(): array
    {
        return [
            // Define your filters here, for example:
            // PublicationNameFilter::class,
            // PublicationRankFilter::class,
        ];
    }
}
