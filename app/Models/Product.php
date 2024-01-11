<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    use HasFactory;

    protected $fillable = [
        'product_name',
        'brand_name',
        'category_id',
        'sub_category_id',
        'avatar'
    ];

    public function images() {
        return $this->hasMany(Product_images::class);
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory() {
        return $this->belongsTo(Sub_category::class, 'sub_category_id');
    }
}
