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
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->unique();
            $table->boolean('active')->default(true);;
            $table->timestamps();
        });

        DB::table('sources')->insert([
            [
                'name' => 'guardian',
                'address' => 'https://content.guardianapis.com/search?show-fields=headline,thumbnail,bodyText,firstPublicationDate,sectionName,byline&api-key=',
            ],
            [
                'name' => 'newsapi',
                'address' => 'https://newsapi.ai/api/v1/article/getArticles?query=%7B%22%24query%22%3A%7B%22lang%22%3A%22eng%22%7D%2C%22%24filter%22%3A%7B%22forceMaxDataTimeWindow%22%3A%2231%22%7D%7D&resultType=articles&articlesSortBy=date&apiKey=',
            ],
            [
                'name' => 'nytimes',
                'address' => 'https://api.nytimes.com/svc/search/v2/articlesearch.json?q=election&api-key=TrL9oxEAWGJXZ3koW8MZm8641f9Q53NT&fl=headline,%20multimedia,%20abstract,%20section_name,%20web_url,%20pub_date,%20byline&api-key=',
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
