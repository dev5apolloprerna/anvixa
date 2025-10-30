<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    protected $table = 'document';
    protected $primaryKey = 'document_id';

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'title',
        'slug',
        'document',
        'category_id',
        'subcategory_id',
        'iStatus',
        'isDelete',
    ];

    protected static function booted()
    {
        // hide soft-deleted rows
        static::addGlobalScope('notDeleted', function ($q) {
            $q->where('isDelete', 0);
        });

        // create -> slug from title (unique)
        static::creating(function (Document $m) {
            $m->slug = static::makeUniqueSlug($m->title);
        });

        // update -> refresh slug if title changed
        static::updating(function (Document $m) {
            if ($m->isDirty('title')) {
                $m->slug = static::makeUniqueSlug($m->title, $m->getKey());
            }
        });
    }

    protected static function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'document';
        $slug = $base; $i = 1;
        $q = static::withoutGlobalScope('notDeleted');
        while (
            $q->where('slug', $slug)
              ->when($ignoreId, fn($x)=>$x->where('document_id', '!=', $ignoreId))
              ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }

    public function category(){ return $this->belongsTo(Category::class, 'category_id', 'iCategoryId'); }
    public function subcategory(){ return $this->belongsTo(SubCategory::class, 'subcategory_id', 'iSubCategoryId'); }
}
