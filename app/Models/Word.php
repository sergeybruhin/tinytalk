<?php

namespace App\Models;

use App\Traits\Morphs\Collectionable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Morphs\Taggable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Word extends Model implements HasMedia
{
    use HasFactory;
    use Taggable;
    use Collectionable;
    use InteractsWithMedia;

    /**
     * @return BelongsToMany
     */
    public function wordCollections(): BelongsToMany
    {
        return $this->belongsToMany(
            WordCollection::class,
        );
    }

    /**
     * @return BelongsToMany
     */
    public function phrases(): BelongsToMany
    {
        return $this->belongsToMany(
            Phrase::class,
        );
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('sm')
            ->width(200)
            ->height(150)
            ->performOnCollections('image');

        $this->addMediaConversion('md')
            ->width(400)
            ->height(300)
            ->performOnCollections('image');

        $this->addMediaConversion('lg')
            ->width(800)
            ->height(600)
            ->performOnCollections('image');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->useDisk('media')
            ->acceptsMimeTypes(['image/webp', 'image/png', 'image/jpeg']);
    }
}
