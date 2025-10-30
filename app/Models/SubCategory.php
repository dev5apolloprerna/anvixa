<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
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
        static::addGlobalScope('notDeleted', function ($query) {
            $query->where('isDelete', 0);
        });
    }
}
 
 