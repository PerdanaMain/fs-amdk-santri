<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'description',
        "created_at",
        "updated_at",
    ];

    // relations
    public function users(): HasMany
    {
        return $this->hasMany(User::class, "user_id", "user_id");
    }
}