<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'iCategoryId';

    protected $fillable = [
        'strCategoryName',
        'strSlug',
        'iStatus',
        'isDelete',
        'strIP',
        'created_at',
        'updated_at',
    ];

    protected static function booted()
    {
        // don't show soft-deleted (isDelete = 1)
        static::addGlobalScope('notDeleted', function ($query) {
            $query->where('isDelete', 0);
        });

        // Create: make a slug if none, and make it unique
        static::creating(function (Category $model) {
            $source = $model->strSlug ?: $model->strCategoryName;
            $model->strSlug = static::makeUniqueSlug($source);
        });

        // Update: if name or slug changed, refresh slug (unique)
        static::updating(function (Category $model) {
            // If slug manually provided on update, prefer that; else derive from name
            $source = $model->isDirty('strSlug')
                ? $model->strSlug
                : ($model->isDirty('strCategoryName') ? $model->strCategoryName : null);

            if ($source !== null) {
                $model->strSlug = static::makeUniqueSlug($source, $model->getKey());
            }
        });
    }

    /**
     * Build a unique slug from given text.
     *
     * @param  string|null  $text
     * @param  int|null     $ignoreId  Current row id to ignore when updating
     */
    protected static function makeUniqueSlug(?string $text, ?int $ignoreId = null): string
    {
        $base = Str::slug((string) $text, '-');
        if ($base === '') {
            $base = 'category';
        }

        $slug = $base;
        $i = 1;

        // Include deleted rows in uniqueness check so we don't collide with existing slugs.
        $query = static::withoutGlobalScope('notDeleted');

        while (
            $query->where('strSlug', $slug)
                  ->when($ignoreId, fn($q) => $q->where('iCategoryId', '!=', $ignoreId))
                  ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
