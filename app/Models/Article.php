<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['user_id', 'name', 'description', 'link'];

    //Relations
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    //Accessors & Mutators
    protected $appends = ['featured_image'];
    public function getFeaturedImageAttribute()
    {
        $media = $this->getMedia('featured-image')->first();
        if($media) {
            return $media->getUrl();
        }
    }

    //Media collections
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('featured-image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->singleFile();
    }
}
