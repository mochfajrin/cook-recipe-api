<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;
    protected $table = "instructions";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        "recipe_id",
        "step",
        "step_order",
        "image",
        "image_id",
    ];
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

}
