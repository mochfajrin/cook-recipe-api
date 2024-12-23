<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("ingredients", function (Blueprint $table) {
            $table->id()->unique();
            $table->unsignedBigInteger("recipe_id");
            $table->string("name", 100);
            $table->unsignedBigInteger("created_at")->default(round(microtime(true) * 1000));

            $table->foreign("recipe_id")->on("recipes")->references("id");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("ingredients");
    }
};
