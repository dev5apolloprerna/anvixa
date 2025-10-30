<?php
// app/Models/Video.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';
    protected $primaryKey = 'video_id';

    // The table already has created_at / updated_at (datetime) -> use Eloquent timestamps:
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'video_title',
        'video_link',
        'image',
        'iStatus',
        'isDelete',
    ];

    // Hide soft-deleted (isDelete = 1)
    protected static function booted()
    {
        static::addGlobalScope('notDeleted', function ($q) {
            $q->where('isDelete', 0);
        });
    }

    /** Relationships */
    public function category()
    {
        // Category pk is iCategoryId, FK in this table is category_id
        return $this->belongsTo(Category::class, 'category_id', 'iCategoryId');
    }

    public function subcategory()
    {
        // SubCategory pk is iSubCategoryId, FK in this table is subcategory_id
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'iSubCategoryId');
    }
}
