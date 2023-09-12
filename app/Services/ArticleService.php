<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Log;
use Akib\Translate\Facades\GoogleTranslate;

class ArticleService
{
    public function persist(array $data): bool
    {
        dump('Storing data...');
        foreach ($data as $key => $article) {

            try {
                $title = GoogleTranslate::translate('de', 'en', $article['title']);
                $excerpt = GoogleTranslate::translate('de', 'en', html_entity_decode($article['excerpt']));
                $date = GoogleTranslate::translate('de', 'en', $article['date']);
                
                Article::updateOrCreate([
                    'title' => $title
                ], [
                    'title' => $title, 
                    'title_link' => $article['href'],
                    'date' => $date,
                    'excerpt' => $excerpt,
                    'image_url' => $article['image']
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