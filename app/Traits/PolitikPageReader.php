<?php

namespace App\Traits;

trait PolitikPageReader
{
    protected function extractTitles()
    {
        $titles = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//header//h2/a[@target="_self"]//@title');
        if (is_object($titles)) {
            foreach ($titles as $key => $title) {
                $this->cleaned_data[$key]['title'] = $title->value;
            }
        }
        
        return true;
    }

    protected function extractLinks()
    {
        $links = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//header//h2/a[@target="_self"]//@href');
        if (is_object($links)) {
            foreach ($links as $key => $link) {
                $this->cleaned_data[$key]['href'] = $link->value;
            }
        }

        return true;
    }

    protected function extractDates()
    {
        $dates = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//footer//span[@data-auxiliary]');
        if (is_object($dates)) {
            foreach ($dates as $key => $date) {
            $this->cleaned_data[$key]['date'] = $date->textContent;
            }
        }

        return true;
    }

    protected function extractExcerpts()
    {
        $excerpts = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//section//a//span[1]');

        if (is_object($excerpts)) {
            foreach ($excerpts as $key => $excerpt) {
                $this->cleaned_data[$key]['excerpt'] = $excerpt->textContent;
            }
        }

        return true;
    }

    protected function extractImageUrls()
    {
        $images = $this->node->evaluate('//div[@data-block-el="articleTeaser"]//article//figure//picture//img//@data-src');

        if (is_object($images)) {
            foreach ($images as $key => $image) {
                $this->cleaned_data[$key]['image'] = $image->value;
            }
        }

        return true;
    }
}