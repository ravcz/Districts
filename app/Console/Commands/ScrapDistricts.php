<?php

namespace App\Console\Commands;

use App\Scraper\Districts\Gdansk;
use App\Scraper\Districts\Krakow;
use App\Scraper\Scraper;
use Illuminate\Console\Command;
use Throwable;

class ScrapDistricts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:districts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap districts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $districtScrapers = [
            new Gdansk(),
            new Krakow(),
        ];

        foreach ($districtScrapers as $districtScraper) {
            try {
                $scraper = new Scraper();
                $scraper->setScraper($districtScraper);
                $scraper->scrap();
            } catch (Throwable $t) {
                $this->error($t->getMessage());
            }
        }
    }
}
