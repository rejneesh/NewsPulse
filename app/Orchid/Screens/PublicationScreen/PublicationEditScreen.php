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
    public $publication;

    public function query(Publication $publication): array
    {
        return [
            'publication' => $publication,
        ];
    }
    public function name(): ?string
    {
        return $this->publication->exists ? 'Edit Publication' : 'Create Publication';
    }

    public function commandBar(): array
    {
        return [
            Button::make('Save')
                ->icon('check')
                ->method('save'),

            // Button::make('Delete')
            //     ->icon('trash')
            //     ->method('remove')
            //     ->canSee($this->publication->exists),
        ];
    }


    public function layout(): array
    {
        return [
            PublicationEditLayout::class,
        ];
    }


    public function save(Request $request, Publication $publication)
    {
        $request->validate([
            // 'publication.publication_name' => 'required|string|max:255',
            // 'publication.publication_url' => 'required|string|max:255',
            // 'publication.publication_rank' => 'required|integer',
            'publication.publication_name' => 'required|string|max:255',
            'publication.publication_url' => 'required|url',
            'publication.publication_rank' => 'required|integer',
            'publication.key_map' => 'nullable|json',
        ]);

        $publication->fill($request->input('publication'))->save();

        Toast::info(__('Publication was saved.'));

        return redirect()->route('platform.publications');
    }


    public function remove(Publication $publication)
    {
        $publication->delete();

        Toast::info(__('Publication was removed.'));

        return redirect()->route('platform.publications');
    }
}
