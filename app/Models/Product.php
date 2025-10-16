<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =
    [
        'proname',
        'catename',
        'price',
        'brandid',
        'cateid',
        'description',
        'fileName'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid', 'cateid')
            ->select(['cateid', 'catename']);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid', 'id')
            ->select(['id', 'brandname']);
    }

}
