<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("users", function (Blueprint $table) {
            $table->string("id", 36)->primary()->unique();
            $table->string("username", 50)->unique();
            $table->string("name", 100);
            $table->string("email");
            $table->string("address");
            $table->string("about_me");
            $table->string("password", 100);
            $table->enum("role", ["admin", "member"]);
            $table->string("image", 150);
            $table->string("image_id", 50);
            $table->unsignedBigInteger("timestamp");
        });
    }

    public function down(): void
    {
        Schema::drop("users");
    }
};
