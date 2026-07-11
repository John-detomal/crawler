<?php

namespace App\Services\Scraper\Crawler;

trait Crawler
{
    protected ?int $pageLimit = null;

    public function maxPages(?int $limit): static
    {
        $this->pageLimit = $limit;

        return $this;
    }
}
