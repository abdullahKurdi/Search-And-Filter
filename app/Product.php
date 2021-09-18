<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public  function category(){
        return $this->belongsTo(Category::class);
    }

    public  function tags(){
        return $this->belongsToMany(Tag::class, 'product_tag','product_id','tag_id');
    }
}
