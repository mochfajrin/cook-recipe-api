<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("recipe_collections", function (Blueprint $table) {
            $table->id()->unique();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("recipe_id");
            $table->unsignedBigInteger("created_at");

            $table->foreign("user_id")->on("users")->references("id");
            $table->foreign("recipe_id")->on("recipes")->references("id");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("recipe_collections");
    }
};
