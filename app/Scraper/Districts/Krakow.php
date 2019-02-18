<?php

namespace App\Scraper\Districts;

use App\Scraper\ScraperAbstract;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use PHPHtmlParser\Dom;
use Throwable;

/**
 * Class Krakow
 * @package App\Scraper\Districts
 */
class Krakow extends ScraperAbstract
{
    public function scrap()
    {
        $dom = new Dom;
        $dom->loadFromUrl('http://www.bip.krakow.pl/?bip_id=1&mmi=10501');
        $iframe = $dom->find('iframe');
        $src = $iframe->getAttribute('src');
        $url = parse_url($src);
        $url = 'http://' . $url['host'] . $url['path'];

        $client = new Client();
        $res = $client->request('GET', $url);
        $contents = $res->getBody()->getContents();
        $contents = mb_convert_encoding($contents, 'UTF-8', 'ISO-8859-1');

        $dom->loadStr($contents);
        $options = $dom->find('#mainDiv select option');

        foreach ($options as $option) {
            try {
                $id = $option->getAttribute('value');
                $res = $client->request('GET', 'http://appimeri.um.krakow.pl/app-pub-dzl/pages/DzlViewGlw.jsf?id=' . $id);
                $contents = $res->getBody()->getContents();
                $contents = mb_convert_encoding($contents, 'UTF-8', 'ISO-8859-1');
                $dom->loadStr($contents);
                $districtName = $dom->find('#mainDiv center h3');
                $population = $dom->find('#mainDiv table table tr td')[3];
                $area = $dom->find('#mainDiv table table td span');

                $values = [
                    'name' => trim(html_entity_decode($districtName->innerHtml)),
                    'city' => 'Kraków',
                    'population' => $population->innerHtml,
                    'area' => floatval(str_replace(',', '.', $area->innerHtml)),
                ];
                if (DB::table('districts')->where($values)->doesntExist()) {
                    DB::table('districts')->insert($values);
                }
            } catch (Throwable $t) {
                dump($t->getMessage());
            }
        }
    }
}
