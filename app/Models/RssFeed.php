<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class RssFeed extends Model
{
    use HasFactory, AsSource;

    protected $table = 'rss_feed';

    protected $primaryKey = 'id';

    // protected $fillable = [
    //     'publication_id',
    //     'rss_endpoint_id',
    //     'title',
    //     'link',
    //     'description',
    //     'category',
    //     'guid',
    //     'pub_date',
    //     'is_processed',
    // ];

    protected $casts = [
        'category' => 'array', // Cast JSON columns to array
        'pub_date' => 'datetime', // Cast to Carbon date
    ];

    public $incrementing = true;
    public $timestamps = true;

    // Define relationships here if any
    public function newsArticles()
    {
        return $this->hasMany(NewsArticle::class, 'rss_feed_endpoint_id');
    }
}
