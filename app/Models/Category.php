<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = "cateid";
    protected $attributes =
    [
        'description' => 'Chưa có mô tả'
    ];
    protected $fillable = ['catename', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class, 'cateid', 'cateid');
    }
}
