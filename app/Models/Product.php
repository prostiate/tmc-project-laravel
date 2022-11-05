<?php

namespace App\Models;

use App\Traits\ReplaceIdWithUuidTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, ReplaceIdWithUuidTraits;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'categories_id',
        'sku',
        'name',
        'price',
        'stock',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'created_at' => 'timestamp',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id')->select('id', 'name');
    }
}
