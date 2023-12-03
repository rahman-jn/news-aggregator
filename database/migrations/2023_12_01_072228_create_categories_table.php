<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->boolean('active')->default(true);;
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['name' => 'politics'],
            ['name' => 'world'],
            ['name' => 'environment'],
            ['name' => 'sport'],
            ['name' => 'general'],
            ['name' => 'usa'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
