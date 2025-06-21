<?php

declare(strict_types=1);

namespace App\Services\TMDB\Repository;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Throwable;

abstract class AbstractRepository
{
    private string $apiUrl = 'https://api.themoviedb.org/3/';

    public function __construct(private readonly string $apiKey, private readonly string $apiLanguage = 'en-US')
    {


    }

    /**
     * Send a GET request to the API.
     *
     * @param string $endpoint
     * @param array<string, int> $parameters
     * @return Collection
     * @throws Throwable
     * @throws ConnectionException
     */
    public function request(string $endpoint, array $parameters = []): Collection
    {
        $url = $this->apiUrl . $endpoint;

        $response = Http::acceptJson()
            ->withQueryParameters($parameters)
            ->get($url, [
                'api_key' => $this->getApiKey(),
                'language' => $this->apiLanguage,
                'append_to_response' => 'videos,images,credits,external_ids,keywords,recommendations,alternative_titles'
            ]);

        return $response->collect();
    }

    private function getApiKey(): string
    {
        return $this->apiKey;
    }
}
