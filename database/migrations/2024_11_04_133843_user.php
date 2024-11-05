<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("users", function (Blueprint $table) {
            $table->id()->unique();
            $table->string("username", 50)->unique()->index("username_index");
            $table->string("name", 100);
            $table->string("email", 255);
            $table->string("address", 100)->nullable();
            $table->string("about_me", 1000)->nullable();
            $table->string("password", 100);
            $table->enum("role", ["ADMIN", "MEMBER"])->default("MEMBER");
            $table->string("image", 150)->nullable();
            $table->string("image_id", 50)->nullable();
            $table->unsignedBigInteger("created_at")->default(round(microtime(true) * 1000));
        });
    }

    public function down(): void
    {
        Schema::drop("users");
    }
};
