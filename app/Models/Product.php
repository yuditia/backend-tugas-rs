<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'stock',
        'price'
    ];

    protected $primaryKey = 'product_id';
    protected $keyType = 'string';
    public $incrementing = false;
}
