<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
        protected $table = 'document';

     protected $primaryKey = 'document_id'; // if that's your PK
    protected $fillable = [
        'title', 'slug', 'document', 'category_id', 'subcategory_id',
        'iStatus', 'isDelete',
        // add any other fields you actually write
    ];

    // Only generate/refresh slug when title is filled and changed
    protected static function booted()
    {
        static::creating(function (Document $m) {
            if (filled($m->title) && blank($m->slug)) {
                $m->slug = static::makeUniqueSlug($m->title);
            }
        });

        static::updating(function (Document $m) {
            // Only touch slug if title actually changed AND is non-empty
            if ($m->isDirty('title') && filled($m->title)) {
                $m->slug = static::makeUniqueSlug($m->title, $m->getKey());
            }
            // If title becomes empty/null, do NOT regenerate slug
        });
    }

    /**
     * Build a unique slug from a title.
     * $ignoreId is used when updating the same row.
     */
    public static function makeUniqueSlug(string $title, $ignoreId = null): string
    {
        $base = Str::slug($title);
        if ($base === '') {
            $base = 'document';
        }

        $slug = $base;
        $i = 1;

        $query = static::query()->where('slug', $slug);
        if ($ignoreId !== null) {
            $query->whereKey('!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = "{$base}-{$i}";
            $query = static::query()->where('slug', $slug);
            if ($ignoreId !== null) {
                $query->whereKey('!=', $ignoreId);
            }
            $i++;
        }

        return $slug;
    }
    public function category(){ return $this->belongsTo(Category::class, 'category_id', 'iCategoryId'); }
    public function subcategory(){ return $this->belongsTo(SubCategory::class, 'subcategory_id', 'iSubCategoryId'); }
}
