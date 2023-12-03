# News aggregator

This project Fetches data from 3 news sources, stores them in localdatabase and provides api endpoints forsearch queries, filtering criteria and user preferences.
Used News sources are:
- NewsAPI: This is a comprehensive API that allows developers to access articles
from more than 70,000 news sources, including major newspapers, magazines, and
blogs. The API provides access to articles in various languages and categories, and
it supports search and filtering.

- The Guardian: This API allows developers to access articles from The Guardian
newspaper, one of the most respected news sources in the world. The API provides
access to articles in various categories and supports search and filtering.

- New York Times: This API allows developers to access articles from The New York
Times, one of the most respected news sources in the world. The API provides
access to articles in various categories and supports search and filtering.

## Installation
Clone the project on your local, go to project root and run these commands:

	composer install
	php artisan migrate

Tables are creted and Some tables initialised after migration.

## Configuration
put your api keys for news data sources in .env file in your root:
	
	NEWSAPI_TOKEN=
	GUARDIANAPI_TOKEN=
	NYTIMESAPI_TOKEN=
		
You have to visit 
		- https://newsapi.ai
		- https://open-platform.theguardian.com/
		- https://developer.nytimes.com/
	to register and get the api keys for free.

## Updating data:

Project is configured to fetch news from sources each hour.
according to the laravel documentation You have to set cronjob as below to allow laravel to run schaduled commands:
	
	* * * * * cd  /Your/project/root/path && php artisan schedule:run >> /dev/null 2>&1

Start the project:

    php artisan serve
default laravel port is 8000, So the project accessable on http://localhost:8000

Update  data manually :

You can update news manually by executing this rquest on web browsers or api request softwares like postman:

    http://localhost/8000/api/news/fetch
## Api end points:

Here are some requests examples for Api endpoints:

    **Queries** : http://localhost:8000/api/news/search?q=example
          
    Filters : http://localhost:8000/api/news/search?author=1&category=2&source=1&date=2023-12-02
        
    User Preferences: http://localhost:8000/api/news/search?authors=1,2&categories=1,2,3&sources=1,2&from_date=2023-12-01&to-date=2023-12-04
    
## Testing
To run provided tests, first write api keys in file: .env.testing, then run the tests.
        
## Response example:

           [
              {
                  "id": 1,
                  "title": "News Title",
                  "content": "News Content",
                   "category" : "world",
                 "published_at": "2023-04-10T12:00:00Z",
                  "images": [
                              "image_url1.jpg",
                               "image_url2.jpg",
                           ],
                   "authors": [
                               "Rahman Jafarinejad",
                                "Jhon Duo",
                            ],
              },
          ],
          
          

