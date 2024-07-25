<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
class NewsArticle extends Model
{
    use HasFactory, AsSource;

    protected $table = 'news_article';

    protected $primaryKey = 'post_id';

    // protected $fillable = [
    //     'publication_id',
    //     'rss_endpoint_id',
    //     'title',
    //     'description',
    //     'h1',
    //     'h2',
    //     'h3',
    //     'body',
    //     'industry',
    //     'segment',
    //     'link',
    //     'scraping_complete',
    //     'is_processed',
    //     'author',
    //     'pub_date',
    //     'score',
    // ];

    protected $casts = [
        'pub_date' => 'datetime', // Cast to Carbon date
    ];

    public $incrementing = true;
    public $timestamps = true;

    // Define relationships here if any
}
