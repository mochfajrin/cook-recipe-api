<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeCollection extends Model
{
    use HasFactory;
    protected $table = "recipe_collections";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        "user_id",
        "recipe_id",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
