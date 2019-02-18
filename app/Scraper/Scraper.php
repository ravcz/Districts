<?php

namespace App\Scraper;

/**
 * Class Scraper
 * @package App\Scraper
 */
class Scraper
{
    /** @var ScraperAbstract */
    private $scraper;

    public function scrap(){
        $this->scraper->scrap();
    }

    /**
     * @param mixed $scraper
     */
    public function setScraper(ScraperAbstract $scraper): void
    {
        $this->scraper = $scraper;
    }
}
