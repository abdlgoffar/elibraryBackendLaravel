<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("title", 400);
            $table->foreignId("category")->nullable();
            $table->foreignId("bookImage")->nullable();
            $table->foreignId("bookPortableDocFormat")->nullable();
            $table->foreignId("user")->nullable();
            $table->integer("amount");
            $table->string("description", 550);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
