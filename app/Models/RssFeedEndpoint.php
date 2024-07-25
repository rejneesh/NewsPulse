<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RssFeed;
use Orchid\Screen\AsSource;

class RssFeedEndpoint extends Model
{
    use HasFactory, AsSource;

    protected $table = 'rss_feed_endpoint';
    protected $primaryKey = 'rss_feed_endpoint_id';

    protected $fillable = [
        'publication_url',
        'endpoint',
        'note',
        'last_fetched',
        'last_fetched_status'
    ];

    protected $casts = [
        'last_fetched' => 'datetime'
    ];

    public $incrementing = true;
    public $timestamps = true;

    // Define relationships
    public function rssFeeds()
    {
        return $this->hasMany(RssFeed::class, 'rss_feed_endpoint_id');
    }


    public function publication()
    {
        return $this->belongsTo(Publication::class, 'publication_url', 'publication_url');
    }

    // public function getContent()
    // {
    //     return $this->endpoint; // Or any other logic to return content
    // }
}
