<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['brandname', 'description'];
    protected $attributes =
    [
        'description' => 'Chưa có mô tả'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brandid', 'id');
    }
}
