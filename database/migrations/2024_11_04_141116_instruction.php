<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create("instructions", function(Blueprint $table) {
        $table->id()->primary();
        $table->unsignedBigInteger("recipe_id");
        $table->string("step");
        $table->smallInteger("order_step");
        $table->string("image")->nullable();
        $table->string("image_id")->nullable();
        $table->unsignedBigInteger("timestamp");

        $table->foreign("recipe_id")->on("recipes")->references("id");
       });
    }

    public function down(): void
    {
        Schema::dropIfExists("instructions");
    }
};
