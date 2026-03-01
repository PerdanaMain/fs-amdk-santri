<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'purchases';
    protected $primaryKey = 'purchase_id';
    protected $fillable = [
        'stock_id',
        'status_id',
        'user_id',
        "finance_id",
        "customer_id",
        "payment_id",
        "payment_status",
        'purchase_description',
        'purchase_quantity',
        'purchase_price',
        'purchase_total',
        "created_at",
        "updated_at",
    ];

    // relationship
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'stock_id');
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function finance(): BelongsTo
    {
        return $this->belongsTo(Finance::class, 'finance_id', 'finance_id');
    }
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}