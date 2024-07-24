<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RssFeed;

class PublicationRssFeedEndpoint extends Model
{
    use HasFactory;

    protected $table = 'publication_rss_feed_endpoint';

    protected $primaryKey = 'rss_endpoint_id';

    // protected $fillable = [
    //     'publication_id',
    //     'endpoint',
    //     'name',
    //     'best_fetch_time',
    //     'last_fetched',
    // ];

    public $incrementing = true;
    public $timestamps = true;

    // Define relationships here if any
    public function rssFeeds()
    {
        return $this->hasMany(RssFeed::class, 'rss_endpoint_id');
    }
}
