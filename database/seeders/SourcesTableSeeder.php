<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
}
