<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'stock_id';
    protected $fillable = [
        'supplier_id',
        'stock_name',
        'stock_photo',
        'stock_quantity',
        'stock_satuan',
        'stock_description',
        "created_at",
        "updated_at",
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'stock_id', 'stock_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}
