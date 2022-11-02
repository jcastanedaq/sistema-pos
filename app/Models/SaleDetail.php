<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    //sail artisan make:model SaleDetail -m

    protected $fillable = [
        'price',
        'quantity',
        'product_id',
        'sale_id',
    ];
}
