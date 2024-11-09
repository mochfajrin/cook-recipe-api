<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("recipes", function (Blueprint $table) {
            $table->id()->unique();
            $table->unsignedBigInteger("user_id");
            $table->string("title", 100);
            $table->string("summary", 1000)->nullable();
            $table->string("portion", 1000)->nullable();
            $table->string("prep_time", 50)->nullable();
            $table->boolean("is_public")->default(false);
            $table->string("header_image", 150)->nullable();
            $table->string("header_image_id", 24)->nullable();
            $table->unsignedFloat("created_at")->default(round(microtime(true) * 1000));

            $table->foreign("user_id")->on("users")->references("id");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("recipes");
    }
};
