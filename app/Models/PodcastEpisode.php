<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PodcastEpisode extends Model
{
    protected $table = 'podcast_episode';
    protected $primaryKey = 'podcast_id';
    protected $keyType = 'int';
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $fillable = [
        'slug',
        'category_id',
        'subcategory_id',
        'podcast_title',
        'video_link',
        'image',
        'iStatus',
        'isDelete',
    ];

    protected static function booted()
    {
        static::addGlobalScope('notDeleted', function ($q) {
            $q->where('isDelete', 0);
        });

        static::creating(function (PodcastEpisode $podcast) {
            $podcast->slug = static::makeUniqueSlug($podcast->podcast_title);
        });

        static::updating(function (PodcastEpisode $podcast) {
            if ($podcast->isDirty('podcast_title')) {
                $podcast->slug = static::makeUniqueSlug($podcast->podcast_title, $podcast->getKey());
            }
        });
    }

    protected static function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title, '-');
        $slug = $base;
        $i = 1;
        $query = static::withoutGlobalScope('notDeleted');
        while (
            $query->where('slug', $slug)
                  ->when($ignoreId, fn($q) => $q->where('podcast_id', '!=', $ignoreId))
                  ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'iCategoryId');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'iSubCategoryId');
    }
}
