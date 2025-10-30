<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{

    protected $table = 'gallery';
    protected $primaryKey = 'gallery_id';
    public $incrementing = false; // your table has no AUTO_INCREMENT; see “DB fix” below
    protected $keyType = 'int';

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'gallery_id',      // only needed if you keep no AUTO_INCREMENT
        'title',
        'slug',
        'image',
        'category_id',
        'subcategory_id',  // note the table’s column name
        'iStatus',
        'isDelete',
    ];

    protected static function booted()
    {
        // hide soft-deleted rows
        static::addGlobalScope('notDeleted', function ($q) {
            $q->where('isDelete', 0);
        });

        // assign id if no auto-increment (simple max+1)
        static::creating(function (Gallery $m) {
            if (!$m->getKey()) {
                $m->gallery_id = (int) (static::withoutGlobalScope('notDeleted')->max('gallery_id') + 1);
            }
            $m->slug = static::makeUniqueSlug($m->title);
        });

        static::updating(function (Gallery $m) {
            if ($m->isDirty('title')) {
                $m->slug = static::makeUniqueSlug($m->title, $m->getKey());
            }
        });
    }

    protected static function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'gallery';
        $slug = $base; $i = 1;
        $q = static::withoutGlobalScope('notDeleted');
        while (
            $q->where('slug', $slug)
              ->when($ignoreId, fn($x)=>$x->where('gallery_id','!=',$ignoreId))
              ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'iCategoryId');
    }

    public function subcategory()
    {
        // note: using DB column `subcatrgory_id`
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'iSubCategoryId');
    }
}
