<?php

namespace Tests\Feature;

use App\Models\Source;
use App\Services\FetchNewsService;
use App\Services\NewsService;

use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\SourcesTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsFetchTest extends TestCase
{
    use RefreshDatabase;

    public static function sourceDataProvider(): array
    {
        return [
            ['guardian'],
            ['nytimes'],
            ['newsapi'],
            // Add more sources as needed
        ];
    }

    public function setUp(): void
    {
        parent::setUp();

        // Seed the database with fixed values
        $this->seed(SourcesTableSeeder::class);

        $this->seed(CategoriesTableSeeder::class);
    }
    /**
     * @dataProvider sourceDataProvider
     *
     * @param string $sourceName
     */
    public function testFetchNewsFromSourcesApi(string $sourceName): void
    {
            $rawNews = $this->sourceRawNews($sourceName);
            $this->assertNotEmpty($rawNews);
    }

    /**
     * @dataProvider sourceDataProvider
     *
     * @param string $sourceName
     */
    public function testTransformingSourcesApiData(string $sourceName): void
    {
        $transformedNews = $this->transformNews($sourceName);

        $this->assertArrayHasKey('title', $transformedNews[0]);

        $this->assertArrayHasKey('content', $transformedNews[0]);

        $this->assertArrayHasKey('category_id', $transformedNews[0]);

        $this->assertArrayHasKey('published_at', $transformedNews[0]);

        $this->assertArrayHasKey('url', $transformedNews[0]);
    }

    /**
     * @dataProvider sourceDataProvider
     *
     * @param string $sourceName
     */
    public function testStoringGuardianApiData(string $sourceName): void
    {
            $newsService = new NewsService();

            $sourceInstance = $this->getByName($sourceName);

            $transformedNews = $this->transformNews($sourceName);

            if($transformedNews) {

                $newsService->createNews($transformedNews, $sourceInstance->id);

                $this->assertDatabaseHas('news', ['title' => $transformedNews[0]['title']]);
            }
    }


    public function sourceRawNews($sourceName): array
    {
        //Guardian api record
        $sourceInstance = $this->getByName($sourceName);

        $newsApiService = new FetchNewsService();

        return $newsApiService->rawNews($sourceInstance);
    }

    public function transformNews($sourceName): array{
        //Guardian api record
        $sourceInstance = $this->getByName($sourceName);

        $newsApiService = new FetchNewsService();

        $rawNews = $newsApiService->rawNews($sourceInstance);

        // Call the method that fetches news from the API
        return $newsApiService->transform($rawNews, $sourceName);
    }

    public function getByName($sourceName){

        return Source::whereName($sourceName)->first();

    }
}
