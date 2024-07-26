<?php

declare(strict_types=1);

namespace App\Orchid\Screens\PublicationScreen;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Publication;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Publication\PublicationEditLayout;
use Orchid\Screen\Fields\Code;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Validation\ValidationException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;

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
        $data = $request->validate([
            'publication.publication_name' => 'required|string|max:255',
            'publication.publication_url' => [
                'required',
                'url',
                'regex:/^(?!.*\/$).*$/', // Regular expression to disallow trailing slash
            ],
            'publication.publication_rank' => 'required|integer',
            'publication.key_map' => 'nullable|json',
        ], [
            'publication.publication_url.required' => 'The publication URL is required.',
            'publication.publication_url.url' => 'The publication URL must be a valid URL.',
            'publication.publication_url.regex' => 'The publication URL must not end with a trailing slash. "/"',
        ]);

        $url = $data['publication']['publication_url'];

        if (!$this->urlExists($url)) {
            return redirect()->back()->withErrors([
                'publication.publication_url' => 'The URL does not exist or cannot be reached.',
            ]);
        }

        $publication->fill($data['publication'])->save();

        Toast::info(__('Publication was saved.'));

        return redirect()->route('platform.publications');
    }

    protected function urlExists($url)
    {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200');
    }

    public function remove(Publication $publication)
    {
        $publication->delete();

        Toast::info(__('Publication was removed.'));

        return redirect()->route('platform.publications');
    }
}
