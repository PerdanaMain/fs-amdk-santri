<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sales';
    protected $primaryKey = 'sale_id';
    protected $fillable = [
        'stock_id',
        'customer_id',
        'payment_id',
        'status_id',
        "user_id",
        "finance_id",
        'sale_quantity',
        'sale_price',
        'sale_total',
        'sale_description',
        'sale_invoice',
        "sale_date",
        "sale_reject_message",
        "payment_status",
        "created_at",
        "updated_at",
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, "customer_id", "customer_id");
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, "payment_id", "payment_id");
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, "stock_id", "stock_id");
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, "status_id", "status_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }

    public function finance(): BelongsTo
    {
        return $this->belongsTo(Finance::class, "finance_id", "finance_id");
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class, "sale_id", "sale_id");
    }
}