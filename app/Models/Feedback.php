<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $primaryKey = 'feedback_id';
    protected $fillable = [
        "feedback_firstname",
        "feedback_lastname",
        "feedback_email",
        "feedback_message",
        "feedback_phone",
        "created_at",
        "updated_at",
    ];
}
