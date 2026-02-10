<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'stock_id';
    protected $fillable = [
        'stock_name',
        'stock_photo',
        'stock_quantity',
        'stock_satuan',
        'stock_description',
        "created_at",
        "updated_at",
    ];
}
