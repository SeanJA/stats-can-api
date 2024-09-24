<?php

// used to generate the enums, but

use GuzzleHttp\RequestOptions;
use SeanJA\StatsCanAPI\Client;
use GuzzleHttp\Client as GuzzleClient;
use SeanJA\StatsCanAPI\Responses\GetAllCubesList\Cube;
use SeanJA\StatsCanAPI\Responses\GetAllCubesListLite\AllCubesListLite;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/functions.php';

$client = new Client(
    guzzle: new GuzzleClient([
        RequestOptions::VERIFY => false
    ]),
    cache: new FilesystemAdapter('', 0, __DIR__ . '/cache')
);


function writeEnumFile($array)
{
    $text = '<?php' . PHP_EOL . PHP_EOL;
    $text .= 'namespace SeanJA\StatsCanAPI\ValueObjects\Enums;' . PHP_EOL;
    $text .= 'enum ProductIdEnum: int' . PHP_EOL;
    $text .= '{' . PHP_EOL;
    /** @var Cube $item */
    foreach ($array as $key => $value) {
        $text .= buildCase($key, $value);
    }
    $text .= '}' . PHP_EOL;
    file_put_contents(__DIR__ . '/../src/ValueObjects/Enums/ProductIdEnum.php', $text);
}


function generateArrayOfData(AllCubesListLite $cubListLite)
{
    $data = [];

    foreach ($cubListLite as $item) {
        $title = normalizeDescription($item->cubeTitleEn);
        if (isset($data[$title])) {
            for ($i = 2; $i < 100; $i++) {
                $tmp = $title . '_' . $i;
                if (isset($data[$tmp])) {
                    continue;
                } else {
                    $title = $tmp;
                    break;
                }
            }
        }
        $data[$title] = $item->productId;
    }

    return $data;
}

$cubListLite = $client->getAllCubesListLite();

$data = generateArrayOfData($cubListLite);
ksort($data);

writeEnumFile($data, 'ProductIdEnum');


