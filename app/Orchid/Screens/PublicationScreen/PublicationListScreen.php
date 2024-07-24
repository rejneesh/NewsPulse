<?php

declare(strict_types=1);

namespace App\Orchid\Screens\PublicationScreen;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Publication;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Publication\PublicationListLayout;
use App\Orchid\Layouts\Publication\PublicationFiltersLayout;
use App\Orchid\Layouts\Publication\PublicationEditLayout;

class PublicationListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'publications' => Publication::paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Publication';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'All registered News Publications';
    }

    /**
     * @return iterable|null
     */
    // public function permission(): ?iterable
    // {
    //     return [
    //         'platform.systems.users',
    //     ];
    // }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.publication.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            PublicationFiltersLayout::class,
            PublicationListLayout::class,

            Layout::modal('asyncEditPublicationModal', PublicationEditLayout::class)
                ->async('asyncGetPublication'),
        ];
    }

    /**
     * Fetch data for async modals.
     *
     * @param Publication $publication
     *
     * @return array
     */
    public function asyncGetPublication(Publication $publication): iterable
    {
        return [
            'publication' => $publication,
        ];
    }

    /**
     * Save publication data.
     *
     * @param Request $request
     * @param Publication $publication
     */
    public function savePublication(Request $request, Publication $publication): void
    {
        $request->validate([
            'publication.publication_name' => 'required|string|max:255',
            'publication.publication_url' => 'required|string|max:255',
            'publication.publication_rank' => 'required|integer',

            // 'publication.publication_name' => 'required|string|max:255',
            // 'publication.publication_url' => 'required|url',
            // 'publication.publication_rank' => 'required|integer',
            // 'publication.key_map' => 'nullable|json',
        ]);

        $publication->fill($request->input('publication'))->save();

        Toast::info(__('Publication was saved.'));
    }

    /**
     * Remove a publication.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Publication::findOrFail($request->get('id'))->delete();

        Toast::info(__('Publication was removed.'));
    }
}
