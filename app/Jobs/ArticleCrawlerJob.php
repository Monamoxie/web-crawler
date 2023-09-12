<?php

namespace App\Jobs;

use App\Contracts\ReaderInterface;
use App\Readers\PolitikSiteReader;
use App\Services\ArticleService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Flysystem\ReadInterface;

class ArticleCrawlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ReaderInterface $reader, ArticleService $service)
    {
        $article = $reader->crawl();
        $source_language = $article->sourceLang();
        $target_language = $article->targetLang();

        if ($article->parse()) {
            $data = $article->extractTitles()
                ->extractLinks()
                    ->extractDates()
                        ->extractExcerpts()
                            ->extractImageUrls()
                                ->get();

            return $service->persist($data, $source_language, $target_language);
        }
    }
}
