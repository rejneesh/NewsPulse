<?php

namespace App\Orchid\Screens\Feed;

use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use App\Models\RssFeed;
use Orchid\Support\Facades\Layout;
class RssFeedListScreen extends Screen
{
    public $name = 'RSS Feeds';
    public $description = 'List of all RSS feeds';

    public function query(): array
    {
        return [
            'rssfeeds' => RssFeed::all()
        ];
    }

    public function layout(): array
    {
        return [
            Layout::table('rssfeeds', [
         //       TD::make('id', 'ID')->sort(),
                TD::make('title', 'Title')->sort(),
                TD::make('link', 'Link')->sort(),
                TD::make('description', 'Description'),
                // TD::make('category', 'Category')->render(function (RssFeed $rssFeed) {
                //     return implode(', ', json_decode($rssFeed->category, true));
                // }),


           //     TD::make('guid', 'GUID')->sort(),
                TD::make('pub_date', 'Publication Date')->render(function (RssFeed $rssFeed) {
                    return $rssFeed->pub_date ? $rssFeed->pub_date->format('Y-m-d H:i:s') : 'N/A';
                }),
                TD::make('created_at', 'Created At')->sort(),
            ])
        ];
    }
}
