<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use HasFactory;
    protected $table = "visits";
    protected $primaryKey = "visit_id";
    protected $fillable = [
        "customer_id",
        "user_id",
        "visit_description",
        "visit_photo",
        "visit_date",
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, "customer_id", "customer_id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }
}
