<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubCategory extends Model
{
    use HasFactory;
    use Sluggable;

    protected $filltable = [
        'category_id',
        'subcategory_name',
        'subcategory_slug',
        'is_child_of',
        'ordering'
    ];
    public function sluggable(): array
    {
        return [
            'subcategory_slug' => [
                'source' => 'subcategory_name'
            ]
        ];
    }

    public function parentcategory(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function children(){
        return $this->hasMany(SubCategory::class, 'is_child_of', 'id')->orderBy('ordering', 'asc');
    }

}
