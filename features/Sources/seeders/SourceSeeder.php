<?php

namespace Features\Sources\Seeders;

use Features\Sources\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Source::firstOrCreate([
            'name' => env('GUARDIAN_SOURCE_NAME','The Guardian'),
            'api_endpoint' => 'https://content.guardianapis.com/search',
            'api_key' => env('GUARDIAN_API_KEY','55322a4b-f46e-44e0-8b85-6802c1696929')
        ]);

        Source::firstOrCreate([
            'name' => env('NEWSAPI_SOURCE_NAME','The NewsApi'),
            'api_endpoint' => 'https://newsapi.org/v2/everything',
            'api_key' => env('NEWSAPI_API_KEY','044c33f469bd48cab24c212ec728a327')
        ]);

        Source::firstOrCreate([
            'name' => env('NEWSAPIAI_SOURCE_NAME','The NewsApiAi'),
            'api_endpoint' => 'http://eventregistry.org/api/v1/article/getArticles',
            'api_key' => env('NEWSAPIAI_API_KEY','71471e01-29bb-40c1-bd8a-0aba164cb559')
        ]);
    }
}
