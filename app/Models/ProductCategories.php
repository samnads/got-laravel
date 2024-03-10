<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategories extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function sub_categories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
