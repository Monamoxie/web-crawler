<?php

namespace App\Services;

use App\Contracts\ClientInterface;
use  App\Traits\PolitikPageReader;
use App\Models\Article;
use Akib\Translate\Facades\GoogleTranslate as TranslateText;
use Illuminate\Support\Facades\Log;

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

            try {
                $title = TranslateText::translate('de', 'en', $data['title']);
                $excerpt = TranslateText::translate('de', 'en', html_entity_decode($data['excerpt']));
                $date = TranslateText::translate('de', 'en', $data['date']);
                
                Article::updateOrCreate([
                    'title' => $title
                ], [
                    'title' => $title, 
                    'title_link' => $data['href'],
                    'date' => $date,
                    'excerpt' => $excerpt,
                    'image_url' => $data['image']
                ]);
            } catch (\Throwable $th) {
                Log::error('An error was thrown', [$th->getMessage()]);
            }
            
        }
        
        return true;
    }

    public function getAll()
    {
        return Article::latest()->get();
    }

}