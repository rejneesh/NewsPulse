<?php

declare(strict_types=1);

namespace App\Orchid\Screens\PublicationScreen;

use Illuminate\Http\Request;
use App\Models\Publication;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Publication\PublicationEditLayout;

class PublicationEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @return string
     */
    public function name(): ?string
    {
        return 'Edit Publication';
    }

    /**
     * Query data.
     *
     * @param Publication $publication
     *
     * @return array
     */
    public function query(Publication $publication): array
    {
        return [
            'publication' => $publication,
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create')
                ->icon('check')
                ->method('save'),

            // Button::make('Remove')
            //     ->icon('trash')
            //     ->method('remove')
            //     ->canSee($this->publication->exists),
        ];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            PublicationEditLayout::class,
        ];
    }

    /**
     * @param Request $request
     * @param Publication $publication
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Publication $publication)
    {
        $request->validate([
            'publication.publication_name' => 'required|string|max:255',
            'publication.publication_url' => 'required|string|max:255',
            'publication.publication_rank' => 'required|integer',
        ]);

        $publication->fill($request->input('publication'))->save();

        Toast::info(__('Publication was saved.'));

        return redirect()->route('platform.publications');
    }

    /**
     * @param Publication $publication
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Publication $publication)
    {
        $publication->delete();

        Toast::info(__('Publication was removed.'));

        return redirect()->route('platform.publications');
    }
}
