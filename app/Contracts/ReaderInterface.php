<?php

namespace App\Contracts;

interface ReaderInterface
{
    /**
     * Crawl a page
     */
    public function crawl(): ?ReaderInterface;

    /**
     * Parse the crawled data and return status
     */
    public function parse(): bool;

    /**
     * Extracts the titles from the article
     */
    public function extractTitles();

    /**
     * Extracts the article links from the article
     */
    public function extractLinks();

    /**
     * Extracts the published date of the article
     */
    public function extractDates();

    /**
     * Extracts excerpts from the article
     */
    public function extractExcerpts();

    /**
     * Extracts the thumbnail or image urls of the article
     */
    public function extractImageUrls();

    /**
     * Get the language of the source content
     */
    public function sourceLang(): ?string;

    /**
     * Get the language of the target content
     */
    public function targetLang(): ?string;

    /**
     * Get the processed data of the article
     */
    public function get(): array;
}