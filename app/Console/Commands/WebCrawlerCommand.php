<?php

namespace App\Console\Commands;

use App\Contracts\ReaderInterface;
use App\Jobs\ArticleCrawlerJob;
use App\Services\ArticleService;
use Illuminate\Console\Command;

class WebCrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'web:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl a pre-defined url for news content';

    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ArticleService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dump('Starting...');

        ArticleCrawlerJob::dispatch();
        
        dump('Completed...');
        return 0;
    }
}
