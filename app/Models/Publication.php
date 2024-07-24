<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Publication extends Model
{
    use HasFactory, AsSource;

    protected $table = 'publication';

    protected $primaryKey = 'publication_id';

    protected $fillable = [
        'publication_name',
        'publication_url',
        'publication_rank',
        'key_map',
    ];

    public $incrementing = true;
    public $timestamps = true;

    // Define relationships here if any
    public function rssFeedEndpoints()
    {
        return $this->hasMany(PublicationRssFeedEndpoint::class, 'publication_id');
    }
}
