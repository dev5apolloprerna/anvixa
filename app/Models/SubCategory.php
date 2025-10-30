<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $table = 'sub_category';
    protected $primaryKey = 'iSubCategoryId';

    protected $fillable = [
        'strSubCategoryName',
        'strSlug',
        'iCategoryId',
        'iStatus',
        'isDelete',
        'strIP',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'iCategoryId', 'iCategoryId');
    }

    protected static function booted()
    {
        // hide deleted
        static::addGlobalScope('notDeleted', function ($query) {
            $query->where('isDelete', 0);
        });

        // Create: generate slug if absent; make unique
        static::creating(function (SubCategory $model) {
            $source = $model->strSlug ?: $model->strSubCategoryName;
            $model->strSlug = static::makeUniqueSlug($source);
        });

        // Update: if slug provided or name changed, refresh slug (unique)
        static::updating(function (SubCategory $model) {
            $source = $model->isDirty('strSlug')
                ? $model->strSlug
                : ($model->isDirty('strSubCategoryName') ? $model->strSubCategoryName : null);

            if ($source !== null) {
                $model->strSlug = static::makeUniqueSlug($source, $model->getKey());
            }
        });
    }

    /**
     * Build a unique slug from the given text.
     *
     * @param  string|null $text
     * @param  int|null    $ignoreId  (for updates)
     */
    protected static function makeUniqueSlug(?string $text, ?int $ignoreId = null): string
    {
        $base = Str::slug((string) $text, '-');
        if ($base === '') $base = 'subcategory';

        $slug = $base;
        $i = 1;

        // include deleted rows to avoid collisions
        $query = static::withoutGlobalScope('notDeleted');

        while (
            $query->where('strSlug', $slug)
                  ->when($ignoreId, fn($q) => $q->where('iSubCategoryId', '!=', $ignoreId))
                  ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
