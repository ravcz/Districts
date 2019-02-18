<?php

namespace App\Scraper\Districts;

use App\Scraper\ScraperAbstract;
use Illuminate\Support\Facades\DB;
use PHPHtmlParser\Dom;
use Throwable;

/**
 * Class Gdansk
 * @package App\Scraper\Districts
 */
class Gdansk extends ScraperAbstract
{
    public function scrap()
    {
        $dom = new Dom;
        $dom->loadFromUrl('https://www.gdansk.pl/dzielnice');
        $links = $dom->find('.lista-dzielnic a');

        $urls = [];
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if ($href != 'dzielnice') {
                $urls[] = 'https://www.gdansk.pl/' . $href;
            }
        }

        foreach ($urls as $url) {
            try {
                $dom->loadFromUrl($url);
                $contents = $dom->find('#hideMe')->innerHtml;
                $dom->load($contents);

                $values = [
                    'name' => $dom->find('div')[0]->innerHtml,
                    'city' => 'Gdańsk',
                ];

                $area = $dom->find('div')[1]->innerHtml;
                $area = explode('km', $area);
                $count = preg_match_all('!\d+!', $area[0], $matches);

                if ($count > 0 && count($matches[0]) == 2) {
                    $values['area'] = number_format($matches[0][0] . '.' . $matches[0][1], 2);
                } else {
                    $values['area'] = null;
                }

                $population = $dom->find('div')[2]->innerHtml;
                $population = preg_replace('/[^0-9]+/', '', $population);
                $values['population'] = ($population != '') ? $population : null;

                if (DB::table('districts')->where($values)->doesntExist()) {
                    DB::table('districts')->insert($values);
                }
            } catch (Throwable $t) {
                dump($t->getMessage());
            }
        }
    }
}
