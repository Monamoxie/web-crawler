<?php

namespace App\Services;

use App\Contracts\ClientInterface;
use  App\Traits\PolitikPageReader;
use App\Models\Article;

class ArticleService
{
    use PolitikPageReader;

    private $client;

    protected $endpoint = 'https://www.spiegel.de/politik/';

    protected $response;

    protected $node;

    protected $cleaned_data = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function crawl() :?bool
    {
        dump('Crawling...');

        $this->response = $this->client->get($this->endpoint);

        if ($this->response) {
            return $this->parse();
        }

        return null;
    }

    protected function parse(): bool
    {
        dump('Processing data...');

        $doc = new \DOMDocument();
        $doc->loadHTML($this->response);

        $this->node = new \DOMXPath($doc);

        if ($this->node) {
            return true;
        }

        return false;
    }

    public function extract(): bool
    {
        $this->extractTitles();
        
        $this->extractLinks();

        $this->extractDates();

        $this->extractExcerpts();

        $this->extractImageUrls();

        return true;
    }

    public function persist(): bool
    {
        dump('Storing data...');

        foreach ($this->cleaned_data as $key => $data) {
            Article::updateOrCreate([
                'title' => $data['title']
            ], [
                'title' => $data['title'], 
                'title_link' => $data['href'],
                'date' => $data['date'],
                'excerpt' => $data['excerpt'],
                'image_url' => $data['image']
            ]);
        }
        
        return true;
    }

    public function getAll()
    {
        return Article::latest()->get();
    }

}