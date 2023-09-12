<?php

namespace App\Readers;
 
use App\Contracts\ReaderInterface;
use Illuminate\Support\Facades\Http;

class PolitikSiteReader implements ReaderInterface
{ 
    protected $response;

    protected $node;

    protected $data = [];

    public function crawl(): ?ReaderInterface
    {
        dump('Crawling...');
        try {
            $content = Http::get(config('services.politik.url'));
            $content_body = (string) $content->getBody();
            
            libxml_use_internal_errors(true);

            $this->response = $content_body;
        } catch (\Throwable $th) {
            $this->response = false;
        }

        return $this;
    }

    public function parse(): bool
    {
        dump('Processing data...');

        $doc = new \DOMDocument();
        if ($this->response) {
            $doc->loadHTML($this->response);
            $this->node = new \DOMXPath($doc);

            if (!$this->node) {
                return false;
            }
        }
    
        return true;
    }

    public function extractTitles()
    {
        $titles = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//header//h2/a[@target="_self"]//@title');
        if (is_object($titles)) {
            foreach ($titles as $key => $title) {
                $this->data[$key]['title'] = $title->value;
            }
        }
        
        return $this;
    }

    public function extractLinks()
    {
        $links = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//header//h2/a[@target="_self"]//@href');
        if (is_object($links)) {
            foreach ($links as $key => $link) {
                $this->data[$key]['href'] = $link->value;
            }
        }

        return $this;
    }

    public function extractDates()
    {
        $dates = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//footer//span[@data-auxiliary]');
        if (is_object($dates)) {
            foreach ($dates as $key => $date) {
            $this->data[$key]['date'] = $date->textContent;
            }
        }

        return $this;
    }

    public function extractExcerpts()
    {
        $excerpts = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//section//a//span[1]');

        if (is_object($excerpts)) {
            foreach ($excerpts as $key => $excerpt) {
                $this->data[$key]['excerpt'] = $excerpt->textContent;
            }
        }

        return $this;
    }

    public function extractImageUrls()
    {
        $images = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//figure//picture//img//@data-src');

        if (is_object($images)) {
            foreach ($images as $key => $image) {
                $this->data[$key]['image'] = $image->value;
            }
        }

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }

    public function sourceLang(): ?string
    {
        return config('services.politik.source_lang');
    } 

    public function targetLang(): ?string
    {
        return config('services.politik.target_lang');
    } 
}