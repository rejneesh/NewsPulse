<?php

namespace App\Orchid\Screens\Feed;

use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use App\Models\RssFeed;
use Orchid\Support\Facades\Layout;
use Carbon\Carbon;

class RssFeedListScreen extends Screen
{
    public $name = 'RSS Feeds';
    public $description = 'List of all RSS feeds';

    public function query(): array
    {
        return [
            'rssfeeds' => RssFeed::orderBy('pub_date', 'desc')->paginate(15), // Adjust the number and column as needed
        ];
    }

    public function layout(): array
    {
        return [
            Layout::table('rssfeeds', [
                TD::make('id', 'ID')->sort(),
                TD::make('is_processed', 'P')->render(function (RssFeed $rssFeed) {
                    return $rssFeed->is_processed ? 'Y' : 'N';
                })->sort(),
                TD::make('link', 'Link')
                    ->sort()
                    ->render(function (RssFeed $rssFeed) {
                        return '<a href="' . $rssFeed->link . '" target="_blank">' . "&#128279;" . '</a>';
                    }),
                TD::make('title', 'Title')->sort()->width('500px'), // Set the width to 150 pixels,

                //TD::make('description', 'Description'),
                // TD::make('category', 'Category')->render(function (RssFeed $rssFeed) {
                //     return implode(', ', json_decode($rssFeed->category, true));
                // }),

                //  TD::make('guid', 'GUID')->sort(),

                TD::make('pub_date', 'Publication Date')->sort()->render(function (RssFeed $rssFeed) {
                    return $rssFeed->pub_date ? Carbon::parse($rssFeed->pub_date)->format('M d, Y h:i A') : 'N/A';
                }),

                TD::make('created_at', 'Created At')
                    ->sort()
                    ->render(function (RssFeed $rssFeed) {
                        return Carbon::parse($rssFeed->created_at)->format('M d, Y h:i A');
                    }),

                TD::make('time_diff', 'Time Diff')
                    ->render(function (RssFeed $rssFeed) {
                        if ($rssFeed->pub_date && $rssFeed->created_at) {
                            $publishedAt = Carbon::parse($rssFeed->pub_date);
                            $createdAt = Carbon::parse($rssFeed->created_at);
                            $diffInSeconds = $createdAt->diffInSeconds($publishedAt);
                            $diffInHours = $createdAt->diffInHours($publishedAt);

                            return "{$diffInSeconds} Sec ({$diffInHours} Hr)";
                        }
                        return 'N/A';
                    }),
            ])
        ];
    }
}
