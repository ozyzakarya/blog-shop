<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'photo', 'model', 'price',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            // remove relations to category
            $model->categories()->detach();
        });
    }

    /*
     | Accessor
     */
    public function getCategoryListsAttribute()
    {
        if ($this->categories()->count() < 1) {
            return null;
        }
        return $this->categories->lists('id')->all();
    }

    /*
     | Relationship
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
}
