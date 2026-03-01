<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'suppliers';
    protected $primaryKey = 'supplier_id';
    protected $fillable = [
        "supplier_name",
        "supplier_owner",
        "supplier_phone",
        "supplier_address",
        "supplier_description",
        "supplier_coordinate",
        "supplier_photo",
        "created_at",
        "updated_at",
    ];
}
