<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['title','seo_keywords','description','author','datetime_create','views','show_hide'];

    public function category ():BelongsTo
    {
        return $this->belongsTo(CategoriesNews::class,'categories_news_id');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(TagRelationNews::class,'news_id','id');
    }
}
