<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
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
        static::addGlobalScope('notDeleted', function ($query) {
            $query->where('isDelete', 0);
        });
    }
}
 
 