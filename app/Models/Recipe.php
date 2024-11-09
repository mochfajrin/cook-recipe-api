<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = "recipes";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        "user_id",
        "title",
        "summary",
        "portion",
        "prep_time",
        "is_public",
        "header_image",
        "header_image_id",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
