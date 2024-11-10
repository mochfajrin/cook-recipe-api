<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = "ingredients";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        "recipe_id",
        "name",
    ];
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
