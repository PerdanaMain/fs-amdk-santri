<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Finance extends Model
{
    use HasFactory;
    protected $table = 'finances';
    protected $primaryKey = 'finance_id';
    protected $fillable = [
        'supplier_id',
        'finance_code',
        'finance_name',
        'finance_debet',
        'finance_credit',
        'finance_description',
        "created_at",
        "updated_at",
    ];

    public function purchase(): HasOne
    {
        return $this->hasOne(Purchase::class, 'finance_id', 'finance_id');
    }
    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class, 'finance_id', 'finance_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}