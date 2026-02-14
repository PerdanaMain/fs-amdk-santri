<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'asset_id';

    protected $fillable = [
        'asset_code',
        'asset_name',
        'purchase_date',
        'purchase_price',
        'lifetime_years',
        'asset_photo',
        'depreciation_per_month'
    ];

    protected $appends = ['current_value'];

    public function getCurrentValueAttribute()
    {
        $purchaseDate = \Carbon\Carbon::parse($this->purchase_date);
        $now = \Carbon\Carbon::now();
        
        // Calculate months difference
        $monthsDiff = $purchaseDate->diffInMonths($now);
        
        // Ensure we don't calculate negative months if purchase date is in future
        $monthsDiff = max(0, $monthsDiff);

        // Calculate current value: Purchase Price - (Months * Depreciation)
        $currentValue = $this->purchase_price - ($monthsDiff * $this->depreciation_per_month);

        // Ensure value doesn't go below 0
        return max(0, $currentValue);
    }
}
