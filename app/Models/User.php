<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = "users";
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = [
        "username",
        "password",
        "name",
        "email",
        "address",
        "image",
        "image_id",
        "about_me",
    ];
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
    public function recipeCollection()
    {
        return $this->hasMany(RecipeCollection::class);
    }
}
